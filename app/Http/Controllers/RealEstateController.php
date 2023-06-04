<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CleanTextController;
use App\Models\Realestate;
use App\Models\RealestateMultiImage;
use App\Models\RealestateTag;
use App\Models\RealestateTranslation;
use App\Models\TagTranslation;

class RealEstateController extends Controller
{
    public function RealEstate()
    {
        $realestates = Realestate::withoutTrashed()->latest()->paginate(10);
        $trashed = Realestate::onlyTrashed()->count();
        $update = null;
        return view('admin.real_estate.real_estate_all', compact('realestates', 'trashed', 'update'));
    }

    public function CreateRealEstate()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.real_estate.real_estate_add', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        // dd($request->recommended_property);
        $request->validate([
            'en_title' => 'required',
            'en_description' => 'required',
            'price' => 'required',
            'en_address' => 'required',
            'area' => 'required',
            'map'=>'required',
            'realestate_images' => 'required|between:1,2048',
            'category' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
        ], [
            'en_title' => 'The title field is required',
            'en_description' => 'The description field is required',
            'price' => 'The price field is required',
            'en_address' => 'The address field is required',
            'map'=>'Please enter map information',
            'area' => 'The area field is required',
            'realestate_images' => 'Please choose images',
            'category' => 'Please select the category',
            'image' => 'Choose an image, Please!',
        ]);

        $en_title = strip_tags($request->en_title);
        $title = strip_tags($request->title);
        $valid_en = RealestateTranslation::where('title', $en_title)->where('locale', 'en')->first();
        $valid_la = RealestateTranslation::where('title', $title)->where('locale', 'la')->first();
        $valid_ch = RealestateTranslation::where('title', $title)->where('locale', 'cn')->first();

        if ($valid_en || $valid_la || $valid_ch) {
            $notification = array(
                'message' => 'This Post Already have! Please try again!!', 'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $save_url = 'storage/media/' . $name_gen;

        $img = Image::make($image->getRealPath());
        $img->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
        })->save($save_url);

        // clean script function
        $cleanText = new CleanTextController();
        $en_description = $cleanText->ReplaceScriptWithPTag($request->en_description);
        $en_address = $cleanText->ReplaceScriptWithPTag($request->en_address);

        $description = $cleanText->ReplaceScriptWithPTag($request->description);

        $price = $cleanText->ReplaceScriptWithPTag($request->price);
        $area = $cleanText->ReplaceScriptWithPTag($request->area);
        // $longitude = $cleanText->ReplaceScriptWithPTag($request->longitude);
        // $latitude = $cleanText->ReplaceScriptWithPTag($request->latitude);
        $address = $cleanText->ReplaceScriptWithPTag($request->address);

        $realestate = Realestate::create([
            'user_id' => Auth::user()->id,
            'category_id' => $request->category,
            'publish' => $request->status,
            'hot_property' => $request->hot_property,
            'recommended_property' => $request->recommended_property,
            'feature_image' => $save_url,
            'status' => 'true',
            'price' => $price,
            'area' => $area,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'map'=>$request->map,
            'view'=> 0,
            'created_at' => Carbon::now(),
        ]);
        RealestateTranslation::insert([
            'realestate_id' => $realestate->id,
            'locale' => 'en',
            'title' => $en_title,
            'slug' => strtolower(str_replace(' ', '-', $en_title)),
            'description' => $en_description,
            'address' => $en_address,
        ]);

        RealestateTranslation::insert([
            'realestate_id' => $realestate->id,
            'locale' => 'la',
            'title' => $title,
            'slug' => strtolower(str_replace(' ', '-', $title)),
            'description' => $description,
            'address' => $address,
        ]);

        $slug = $title . rand(0, 1000);
        RealestateTranslation::insert([
            'realestate_id' => $realestate->id,
            'locale' => 'cn',
            'title' => $en_title,
            'slug' => strtolower(str_replace(' ', '-', $slug)),
            'description' => $en_description,
            'address' => $en_address,
        ]);
        if ($request->has('realestate_images')) {
            foreach ($request->file('realestate_images') as $mul_image) {
                $mul_name_gen = hexdec(uniqid()) . '.' . $mul_image->getClientOriginalExtension();
                $save_url = 'storage/media/' . $mul_name_gen;
                $img = Image::make($mul_image->getRealPath());

                $img->resize(1500, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);

                RealestateMultiImage::insert([
                    'realestate_id' => $realestate->id,
                    'image' => $save_url,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        if ($request->has('tags')) {
            $realestate->tags()->attach($request->tags);
        }

        $notification = array(
            'message' => 'Real Estate Inserted Successfully', 'alert-type' => 'success'
        );

        return redirect()->route('realestate')->with($notification);
    } //end method store real estate


    public function deleteRealestate(Request $request)
    {
        Realestate::findOrFail($request->id)->delete();
        $notification = array(
            'message' => 'Item Deleted Successfully', 'alert-type' => 'warning'
        );
        return redirect()->route('realestate')->with($notification);
    }



    public function editLaoRealestate(Request $request, $id)
    {
        $id = $request->id;
        $locale = app()->getLocale();
        $realestate = Realestate::findOrFail($id);
        $categories = Category::all();

        $en_realestate = RealestateTranslation::where('realestate_id', $id)->where('locale', 'en')->first();
        $la_realestate = RealestateTranslation::where('realestate_id', $id)->where('locale', 'la')->first();

        $realestate_images = DB::table('realestate_multi_images')->where('realestate_id', $id)->get();
        $category = CategoryTranslation::where('category_id', $realestate->category_id)->where('locale', $locale)->first();
        $realestate_tag = RealestateTag::where('realestate_id', $id)->get();
        $tags = Tag::all();

        return view(
            'admin.real_estate.real_estate_edit_la',
            compact(
                'en_realestate',
                'realestate',
                'la_realestate',
                'realestate_images',
                'categories',
                'tags',
                'category',
                'realestate_tag'
            )
        );
    } //end method

    public function editChineseRealestate(Request $request)
    {
        $id = $request->id;
        $locale = app()->getLocale();
        $realestate = Realestate::findOrFail($id);
        $categories = Category::all();

        $en_realestate = RealestateTranslation::where('realestate_id', $id)->where('locale', 'en')->first();
        $cn_realestate = RealestateTranslation::where('realestate_id', $id)->where('locale', 'cn')->first();

        $realestate_images = DB::table('realestate_multi_images')->where('realestate_id', $id)->get();
        $category = CategoryTranslation::where('category_id', $realestate->category_id)->where('locale', $locale)->first();
        $realestate_tag = RealestateTag::where('realestate_id', $id)->get();
        $tags = Tag::all();

        return view(
            'admin.real_estate.real_estate_edit_cn',
            compact(
                'en_realestate',
                'realestate',
                'cn_realestate',
                'realestate_images',
                'categories',
                'tags',
                'category',
                'realestate_tag'
            )
        );
    } //end method

    public function updateLaoRealestate(Request $request)
    {
        $request->validate([
            'en_title' => 'required',
            'en_description' => 'required',
            'price' => 'required',
            'en_address' => 'required',
            'map' => 'required',
            'area' => 'required',
            'category' => 'required',
            'title' => 'required',
            'address' => 'required',
            'description' => 'required',
            // 'longitude' => 'required',
            // 'latitude' => 'required'
        ], [
            'en_title' => 'The title field is required',
            'en_description' => 'The description field is required',
            'price' => 'The price field is required',
            'en_address' => 'The address field is required',
            'map' => 'Please enter map information',
            'area' => 'The area field is required',
            'category' => 'Please select the category',
            'title' => 'The title field is required',
            'address' => 'The address field is required',
            'description' => 'The description field is required',
            // 'longitude' => 'Please enter longitude number !',
            // 'latitude' => 'Please enter latitude number !',
        ]);

        $en_id = $request->en_id;
        $la_id = $request->la_id;

        $en_title = strip_tags($request->en_title);
        $title = strip_tags($request->title);
        $valid_en = RealestateTranslation::where('title', $en_title)->where('locale', 'en')->first();
        $valid_lang = RealestateTranslation::where('title', $title)->where('locale', 'la')->first();

        if ($valid_en) {
            $db_en_id = $valid_en->id;
            if ($en_id != $db_en_id) {
                $notification = array(
                    'message' => 'This Post Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        if ($valid_lang) {
            $db_la_id = $valid_lang->id;
            if ($la_id != $db_la_id) {
                $notification = array(
                    'message' => 'This Lao Post Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }

        $realestate_id = $request->realestateId;
        $realestate = DB::table('realestates')->where('id', $realestate_id)->get();
        $image = $request->file('image');

        // clean script function
        $cleanText = new CleanTextController();
        $en_description = $cleanText->ReplaceScriptWithPTag($request->en_description);
        $en_address = $cleanText->ReplaceScriptWithPTag($request->en_address);

        $description = $cleanText->ReplaceScriptWithPTag($request->description);
        $price = $cleanText->ReplaceScriptWithPTag($request->price);
        $area = $cleanText->ReplaceScriptWithPTag($request->area);
        // $longitude = $cleanText->ReplaceScriptWithPTag($request->longitude);
        // $latitude = $cleanText->ReplaceScriptWithPTag($request->latitude);
        $address = $cleanText->ReplaceScriptWithPTag($request->address);

        Realestate::findOrFail($realestate_id)->update([
            'user_id' => Auth::user()->id,
            'category_id' => $request->category,
            'publish'=>$request->status == '1' ? '1' : '0',
            'hot_property' => $request->hot_property== '1' ? '1' : '0',
            'recommended_property' => $request->recommended_property== '1' ? '1' : '0',
            'price' => $price,
            'area' => $area,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'map'=>$request->map,
            'updated_at' => Carbon::now(),
        ]);

        RealestateTranslation::findOrFail($en_id)->update([
            'title' => $en_title,
            'slug' => strtolower(str_replace(' ', '-', $en_title)),
            'description' => $en_description,
            'address' => $en_address,
        ]);

        RealestateTranslation::findOrFail($la_id)->update([
            'title' => $title,
            'slug' => strtolower(str_replace(' ', '-', $title)),
            'description' => $description,
            'address' => $address,
        ]);

        if ($request->has('realestate_images')) {
            $request->validate(['realestate_images.*' => 'required|image|mimes:jpeg,jpg,png,jfif|max:2048']);
            foreach ($request->file('realestate_images') as $mul_image) {
                $mul_name_gen = hexdec(uniqid()) . '.' . $mul_image->getClientOriginalExtension();
                $save_url = 'storage/media/' . $mul_name_gen;
                $img = Image::make($mul_image->getRealPath());
                $img->resize(1000, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);

                RealestateMultiImage::insert([
                    'realestate_id' => $realestate_id,
                    'image' => $save_url,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        if ($request->file('image')) {
            $request->validate([
                'image' => 'required|mimes:jpg,jpeg,png,gif,jfif|between:1,2048',
            ]);
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'storage/media/' . $name_gen;
            $img = Image::make($image->getRealPath());
            $img->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
            })->save($save_url);

            Realestate::findOrFail($realestate_id)->update([
                'feature_image' => $save_url
            ]);
            if (file_exists($realestate[0]->feature_image)) {
                unlink($realestate[0]->feature_image);
            }
        }

        $updateRealestate = Realestate::findOrFail($request->realestateId);

        if ($request->has('tags')) {
            RealestateTag::where('realestate_id', $realestate_id)->delete();
            $updateRealestate->tags()->syncWithoutDetaching($request->tags);
        }

        $notification = array(
            'message' => 'Item Updated Successfully', 'alert-type' => 'success'
        );

        return back()->with($notification);
    } //end method update Lao post


    public function updateChinesRealestate(Request $request)
    {
        $request->validate([
            'en_title' => 'required',
            'en_description' => 'required',
            'price' => 'required',
            'en_address' => 'required',
            'map'=>'required',
            'area' => 'required',
            'category' => 'required',
            'title' => 'required',
            'address' => 'required',
            'description' => 'required',
            // 'longitude' => 'required',
            // 'latitude' => 'required',
        ], [
            'en_title' => 'The title field is required',
            'en_description' => 'The description field is required',
            'price' => 'The price field is required',
            'en_address' => 'The address field is required',
            'map'=>'Please enter map information',
            'area' => 'The area field is required',
            'category' => 'Please select the category',
            'title' => 'The title field is required',
            'address' => 'The address field is required',
            'description' => 'the description field is required',
            // 'longitude' => 'Please enter longitude number !',
            // 'latitude' => 'Please enter latitude number !',
        ]);

        $en_id = $request->en_id;
        $cn_id = $request->cn_id;

        $en_title = strip_tags($request->en_title);
        $title = strip_tags($request->title);
        $valid_en = RealestateTranslation::where('title', $en_title)->where('locale', 'en')->first();
        $valid_lang = RealestateTranslation::where('title', $title)->where('locale', 'cn')->first();

        if ($valid_en) {
            $db_en_id = $valid_en->id;
            if ($en_id != $db_en_id) {
                $notification = array(
                    'message' => 'This English Title Already token! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        if ($valid_lang) {
            $db_cn_id = $valid_lang->id;
            if ($cn_id != $db_cn_id) {
                $notification = array(
                    'message' => 'This Chinese Title Already token! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }

        $realestate_id = $request->realestateId;
        $realestate = DB::table('realestates')->where('id', $realestate_id)->get();
        $image = $request->file('image');

        // clean script function
        $cleanText = new CleanTextController();
        $en_description = $cleanText->ReplaceScriptWithPTag($request->en_description);
        $en_address = $cleanText->ReplaceScriptWithPTag($request->en_address);

        $description = $cleanText->ReplaceScriptWithPTag($request->description);
        $price = $cleanText->ReplaceScriptWithPTag($request->price);
        $area = $cleanText->ReplaceScriptWithPTag($request->area);
        // $longitude = $cleanText->ReplaceScriptWithPTag($request->longitude);
        // $latitude = $cleanText->ReplaceScriptWithPTag($request->latitude);
        $address = $cleanText->ReplaceScriptWithPTag($request->address);

        Realestate::findOrFail($realestate_id)->update([
            'user_id' => Auth::user()->id,
            'category_id' => $request->category,
            'publish'=>$request->status == '1' ? '1' : '0',
            'hot_property' => $request->hot_property== '1' ? '1' : '0',
            'recommended_property' => $request->recommended_property== '1' ? '1' : '0',
            'price' => $price,
            'area' => $area,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'map'=>$request->map,
            'updated_at' => Carbon::now(),
        ]);

        RealestateTranslation::findOrFail($en_id)->update([
            'title' => $en_title,
            'slug' => strtolower(str_replace(' ', '-', $en_title)),
            'description' => $en_description,
            'address' => $en_address,
        ]);
        $slug = $title . rand(0, 1000);
        RealestateTranslation::findOrFail($cn_id)->update([
            'title' => $title,
            'slug' => strtolower(str_replace(' ', '-', $slug)),
            'description' => $description,
            'address' => $address,
        ]);

        if ($request->has('realestate_images')) {
            $request->validate(['realestate_images.*' => 'required|image|mimes:jpeg,jpg,png,jfif|max:2048']);
            foreach ($request->file('realestate_images') as $mul_image) {
                $mul_name_gen = hexdec(uniqid()) . '.' . $mul_image->getClientOriginalExtension();
                $save_url = 'storage/media/' . $mul_name_gen;
                $img = Image::make($mul_image->getRealPath());
                $img->resize(1000, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);

                RealestateMultiImage::insert([
                    'realestate_id' => $realestate_id,
                    'image' => $save_url,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        if ($request->file('image')) {
            $request->validate([
                'image' => 'required|mimes:jpg,jpeg,png,gif,jfif|between:1,2048',
            ]);
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'storage/media/' . $name_gen;
            $img = Image::make($image->getRealPath());
            $img->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
            })->save($save_url);

            Realestate::findOrFail($realestate_id)->update([
                'feature_image' => $save_url
            ]);
            if (file_exists($realestate[0]->feature_image)) {
                unlink($realestate[0]->feature_image);
            }
        }

        $updateRealestate = Realestate::findOrFail($request->realestateId);
        if ($request->has('tags')) {
            RealestateTag::where('realestate_id', $realestate_id)->delete();
            $updateRealestate->tags()->syncWithoutDetaching($request->tags);
        }

        $notification = array(
            'message' => 'Item Updated Successfully', 'alert-type' => 'success'
        );

        return back()->with($notification);
    } //end method update Chinese post




    public function deleteRealestateSingleImage(Request $request)
    {
        $id = $request->id;
        $single_image = RealestateMultiImage::findOrFail($id);
        if (file_exists($single_image->image)) {
            unlink($single_image->image);
        }
        $single_image->delete();

        $notification = array(
            'message' => 'Delete Image Successfully', 'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function DeletePostTag(Request $request)
    {
        $realestate_id = $request->realestate_id;
        $tag_id = $request->tag_id;
        $post = Realestate::findOrFail($realestate_id);
        $post->tags()->detach($tag_id);
        $notification = array(
            'message' => 'Delete Tag from this post Successfully', 'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function index()
    {
        $trashed = Realestate::onlyTrashed()->get();
        return view('admin.real_estate.real_estate_trash', compact('trashed'));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        Realestate::where('id', $id)->withTrashed()->restore();
        $notification = array(
            'message' => 'Restore Item Sucessfully!!', 'alert-type' => 'success'
        );
        return redirect()->route('realestate')->with($notification);
    }

    public function force_delete(Request $request)
    {
        $id = $request->id;
        $multi_image = DB::table('realestate_multi_images')->where('realestate_id', $id)->get();
        foreach ($multi_image as $image) {
            if (file_exists($image->image)) {
                unlink($image->image);
            }
        }
        $image = RealestateMultiImage::where('realestate_id', $id)->delete();

        $realestate = DB::table('realestates')->where('id', $id)->first();
        $single_image = $realestate->feature_image;
        if (file_exists($single_image)) {
            unlink($single_image);
        }
        Realestate::where('id', $id)->withTrashed()->forceDelete();

        $notification = array(
            'message' => 'Deleted Item Sucessfully!!', 'alert-type' => 'danger'
        );

        return back()->with($notification);
    } //end method force delete post

    public function getTags(Request $request)
    {
        // dd($request);
        $tags = [];
        if ($search = $request->name) {
            $tags = TagTranslation::where('name', 'LIKE', "%$search%")->get();
        }

        return response()->json($tags);
    }




    public function Publish(Request $request)
    {
        $id = $request->id;
        $data = Realestate::findOrFail($id);
        if ($data->publish == '1') {
            $data->publish = '0';
            $data->save();
            $notification = array('message' => 'Status Off!', 'alert-type' => 'warning');
            return redirect()->back()->with($notification);
        } elseif ($data->publish == '0') {
            $data->publish = '1';
            $data->save();
            $notification = array('message' => 'Status On!', 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }
    } //end method

}
