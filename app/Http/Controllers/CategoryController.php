<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
    public function Category()
    {
        $isUpdate = null;
        $categories = Category::withoutTrashed()->get();
        $trashed = Category::onlyTrashed()->count();
        return view('admin.category.category_all', compact('isUpdate', 'categories', 'trashed'));
    }

    public function StoreCategory(Request $request)
    {
        $locale = app()->getLocale();
        $request->validate([
            'en_name' => 'required',
            'la_name' => 'required',
            'cn_name' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif,jfif|between:1,2048',
        ], [
            'en_name' => $locale == 'en' ? 'Please enter English category name'
                : ($locale == 'la' ? 'ກະລຸນາປ້ອນຊື່ປະເພດເປັນພາສາອັງກິດ'
                    : '请输入英文类别名称'),
            'la_name' => $locale == 'en' ? 'Please enter Lao category name'
                : ($locale == 'la' ? 'ກະລຸນາປ້ອນຊື່ປະເພດເປັນພາສາລາວ'
                    : '请输入老挝类别名称'),
            'cn_name' => $locale == 'en' ? 'Please enter Chinese category name'
                : ($locale == 'la' ? 'ກະລຸນາປ້ອນຊື່ປະເພດເປັນພາສາຈີນ'
                    : '请输入中文类别名称'),
            'image' => $locale == 'en' ? 'Please choose and image'
                : ($locale == 'la' ? 'ກະລຸນາເລືອກຮູບ'
                    : '请选择图片'),
        ]);

        $en_name = strip_tags($request->en_name);
        $la_name = strip_tags($request->la_name);
        $cn_name = strip_tags($request->cn_name);
        $valid_en = CategoryTranslation::where('name', $en_name)->where('locale', 'en')->first();
        $valid_la = CategoryTranslation::where('name', $la_name)->where('locale', 'la')->first();
        $valid_cn = CategoryTranslation::where('name', $cn_name)->where('locale', 'cn')->first();

        if ($valid_en || $valid_la || $valid_cn) {
            $notification = array(
                'message' => 'This Category Already have! Please try again!!', 'alert-type' => 'error'
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

        $category = Category::create([
            'user_id' => Auth::user()->id,
            'status' => 'true',
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        CategoryTranslation::insert([
            'name' => $en_name,
            'slug' => strtolower(str_replace(' ', '-', $en_name)),
            'locale' => 'en',
            'category_id' => $category->id,
        ]);

        CategoryTranslation::insert([
            'name' => $la_name,
            'slug' => strtolower(str_replace(' ', '-', $la_name)),
            'locale' => 'la',
            'category_id' => $category->id,
        ]);

        CategoryTranslation::insert([
            'name' => $cn_name,
            'slug' => strtolower(str_replace(' ', '-', $cn_name)),
            'locale' => 'cn',
            'category_id' => $category->id,
        ]);

        $notifiction = array(
            'message' => 'Insert Category Successfully', 'alert-type' => 'success'
        );

        return back()->with($notifiction);
    }

    public function DeleteCategory(Request $request)
    {
        $id = $request->id;
        Category::findOrFail($id)->delete();
        $notifiction = array(
            'message' => 'Delete Category Successfully', 'alert-type' => 'success'
        );
        return back()->with($notifiction);
    }

    public function EditCategory(Request $request)
    {
        $id = $request->id;
        $categories = Category::withoutTrashed()->get();
        $data = Category::findOrFail($id);
        $trashed = Category::onlyTrashed()->count();
        $en_cates = CategoryTranslation::where('category_id', $id)->where('locale', 'en')->first();
        $la_cates = CategoryTranslation::where('category_id', $id)->where('locale', 'la')->first();
        $cn_cates = CategoryTranslation::where('category_id', $id)->where('locale', 'cn')->first();
        $isUpdate = 'true';
        return view('admin.category.category_all', compact(
            'categories',
            'isUpdate',
            'en_cates',
            'la_cates',
            'cn_cates',
            'trashed',
            'data'
        ));
    }

    public function UpdateCategory(Request $request)
    {
        $request->validate([
            'en_name' => 'required',
            'la_name' => 'required',
            'cn_name' => 'required',
        ]);

        $en_id = $request->en_id;
        $la_id = $request->la_id;
        $cn_id = $request->cn_id;
        $en_name = strip_tags($request->en_name);
        $la_name = strip_tags($request->la_name);
        $cn_name = strip_tags($request->cn_name);
        $valid_en = CategoryTranslation::where('name', $en_name)->where('locale', 'en')->first();
        $valid_la = CategoryTranslation::where('name', $la_name)->where('locale', 'la')->first();
        $valid_cn = CategoryTranslation::where('name', $cn_name)->where('locale', 'cn')->first();
        if ($valid_en) {
            $db_en_id = $valid_en->id;
            if ($en_id != $db_en_id) {
                $notifiction = array(
                    'message' => 'This Category Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        if ($valid_la) {
            $db_la_id = $valid_la->id;
            if ($la_id != $db_la_id) {
                $notifiction = array(
                    'message' => 'This Category Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        if ($valid_cn) {
            $db_cn_id = $valid_cn->id;
            if ($cn_id != $db_cn_id) {
                $notifiction = array(
                    'message' => 'This Category Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        $id = $request->id;
        $old_image = $request->file('image');
        $data = Category::findOrFail($id);

        $db_image = $data->image;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
            ]);
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $old_image->getClientOriginalExtension();
            $save_url = 'storage/media/' . $name_gen;
            $img = Image::make($image->getRealPath());
            $img->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
            })->save($save_url);

            Category::findOrFail($id)->update([
                'image' => $save_url,
            ]);

            if (file_exists($db_image)) {
                unlink($db_image);
            }
        }

        CategoryTranslation::findOrFail($en_id)->update([
            'name' => $en_name,
            'slug' => strtolower(str_replace(' ', '-', $en_name)),
        ]);

        CategoryTranslation::findOrFail($la_id)->update([
            'name' => $la_name,
            'slug' => strtolower(str_replace(' ', '-', $la_name)),
        ]);
        CategoryTranslation::findOrFail($cn_id)->update([
            'name' => $cn_name,
            'slug' => strtolower(str_replace(' ', '-', $cn_name)),
        ]);

        $notifiction = array(
            'message' => 'Update Successfully', 'alert-type' => 'info'
        );

        return redirect()->route('category')->with($notifiction);
    }

    public function index()
    {
        $trashed = Category::onlyTrashed()->get();
        return view('admin.category.category_trashed', compact('trashed'));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        Category::where('id', $id)->withTrashed()->restore();
        $notifiction = array(
            'message' => 'Restore Category Sucessfully!!', 'alert-type' => 'success'
        );
        return redirect()->route('category')->with($notifiction);
    }

    public function force_delete(Request $request)
    {
        $id = $request->id;
        $category = DB::table('categories')->where('id', $id)->first();
        $image = $category->image;
        if (file_exists($image)) {
            unlink($image);
        }

        Category::where('id', $id)->withTrashed()->forceDelete();
        $notifiction = array(
            'message' => 'Deleted Category Sucessfully!!', 'alert-type' => 'danger'
        );
        return redirect()->route('category')->with($notifiction);
    }
}
