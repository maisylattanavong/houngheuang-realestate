<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CleanTextController;

class BannerController extends Controller
{
    public function index()
    {
        $unpublish = Banner::where('status', 0)->count();
        $banner = Banner::withoutTrashed()->get();
        $trashed = Banner::onlyTrashed()->count();
        return view('admin.banner.index', compact('unpublish', 'banner', 'trashed'));
    }

    public function create()
    {
        $isUpdate = null;
        $banner = null;
        $en_benner = null;
        $la_banner = null;
        return view('admin.banner.manage', compact('en_benner', 'la_banner', 'isUpdate', 'banner'));
    }

    public function store(Request $request)
    {
        $status = $request->publish;

        $request->validate([
            'en_title' => 'required',
            'la_title' => 'required',
            'en_description' => 'required',
            'la_description' => 'required',
            'link' => 'url',
            'la_description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
        ]);

        $en_title = strip_tags($request->en_title);
        $la_title = strip_tags($request->en_title);

        $valid_en = BannerTranslation::where('title', $en_title)->where('locale', 'en')->first();
        $valid_la = BannerTranslation::where('title', $la_title)->where('locale', 'la')->first();
        if ($valid_en || $valid_la) {
            $notifiction = array(
                'message' => 'This Banner Title Already Have! Please Try Again!!', 'alert-type' => 'error'
            );
            return back()->with($notifiction);
        }

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $save_url = 'storage/media/' . $name_gen;

        $img = Image::make($image->getRealPath());
        $img->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
        })->save($save_url);

        if ($status == "on") {
            $public = '1';
        } else {
            $public = '0';
        }

        $banner = Banner::create([
            'user_id' => Auth::user()->id,
            'image' => $save_url,
            'status' => $public,
            'link' => $request->link,
        ]);

        // clean script function
        $cleanText = new CleanTextController();
        $en_description = $cleanText->ReplaceScriptWithPTag($request->en_description);
        $la_description = $cleanText->ReplaceScriptWithPTag($request->la_description);

        BannerTranslation::insert([
            'banner_id' => $banner->id,
            'locale' => 'en',
            'title' => $en_title,
            'description' => $en_description,
        ]);

        BannerTranslation::insert([
            'banner_id' => $banner->id,
            'locale' => 'la',
            'title' => $la_title,
            'description' => $la_description,
        ]);


        $notifiction = array(
            'message' => 'Insert Banner Successfully', 'alert-type' => 'success'
        );

        switch ($request->input('action')) {
            case 'create':
                return redirect()->route('banner.index')->with($notifiction);
                break;
            case 'create-other':
                return redirect()->back()->with($notifiction);
                break;
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $banner = Banner::findOrFail($id);
        $en_banner = BannerTranslation::where('banner_id', $id)->where('locale', 'en')->first();
        $la_banner = BannerTranslation::where('banner_id', $id)->where('locale', 'la')->first();
        $isUpdate = 'update';
        return view('admin.banner.manage', compact('en_banner', 'la_banner', 'isUpdate', 'banner'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'en_title' => 'required',
            'la_title' => 'required',
            'en_description' => 'required',
            'la_description' => 'required',
            'link' => 'url',
            'la_description' => 'required',
        ]);

        $en_id = $request->en_id;
        $la_id = $request->la_id;

        $en_title = strip_tags($request->en_title);
        $la_title = strip_tags($request->en_title);

        $valid_en = BannerTranslation::where('title', $en_title)->where('locale', 'en')->first();
        $valid_la = BannerTranslation::where('title', $la_title)->where('locale', 'la')->first();

        if ($valid_en) {
            $db_en_id = $valid_en->id;
            if ($en_id != $db_en_id) {
                $notifiction = array(
                    'message' => 'This Banner Title Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        if ($valid_la) {
            $db_la_id = $valid_la->id;
            if ($la_id != $db_la_id) {
                $notifiction = array(
                    'message' => 'This Banner Title Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        $data = Banner::findOrFail($id);
        $db_image = $data->image;

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
            ]);

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'storage/media/' . $name_gen;

            $img = Image::make($image->getRealPath());
            $img->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
            })->save($save_url);

            Banner::findOrFail($id)->update([
                'image' => $save_url
            ]);

            if (file_exists($db_image)) {
                unlink($db_image);
            }
        }

        if ($request->publish == "on") {
            $public = '1';
        } else {
            $public = '0';
        }

        Banner::findOrFail($id)->update([
            'user_id' => Auth::user()->id,
            'status' => $public,
            'link' => $request->link,
        ]);

        // clean script function
        $cleanText = new CleanTextController();
        $en_description = $cleanText->ReplaceScriptWithPTag($request->en_description);
        $la_description = $cleanText->ReplaceScriptWithPTag($request->la_description);

        BannerTranslation::findOrFail($request->en_id)->update([
            'title' => $en_title,
            'description' => $en_description,
        ]);

        BannerTranslation::findOrFail($request->la_id)->update([
            'title' => $la_title,
            'description' => $la_description,
        ]);

        $notifiction = array(
            'message' => 'Update Banner Successfully', 'alert-type' => 'info'
        );
        return redirect()->route('banner.index')->with($notifiction);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        Banner::findOrFail($id)->delete();

        $notifiction = array(
            'message' => 'Insert Banner Successfully', 'alert-type' => 'success'
        );
        return back()->with($notifiction);
    }

    public function trashed(Request $request)
    {
        $trashed = Banner::onlyTrashed()->get();
        return view('admin.banner.banner_trashed', compact('trashed'));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        Banner::where('id', $id)->withTrashed()->restore();
        $notifiction = array(
            'message' => 'Restore Banner slider Sucessfully!!', 'alert-type' => 'success'
        );
        return redirect()->route('banner.index')->with($notifiction);
    }

    public function force_delete(Request $request)
    {
        $id = $request->id;
        $banner = DB::table('banners')->where('id', $id)->first();
        $image = $banner->image;
        if (file_exists($image)) {
            unlink($image);
        }

        Banner::where('id', $id)->withTrashed()->forceDelete();
        $notifiction = array(
            'message' => 'Deleted Banner slider Sucessfully!!', 'alert-type' => 'success'
        );
        return redirect()->route('banner.index')->with($notifiction);
    }

    public function toggle(Request $request)
    {
        $id = $request->banner_id;
        $banner = Banner::findOrFail($id);
        $banner->status = $request->status;
        $banner->save();

        if ($request->status == 0) {
            return response()->json(['message' => 'Unpublished Banner Successfully!']);
        } else {
            return response()->json(['message' => 'Published Banner Successfully!']);
        }
    }
}
