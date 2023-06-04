<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TagTranslation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function Tag()
    {
        $tags = Tag::withoutTrashed()->get();
        $trashed = Tag::onlyTrashed()->count();
        $update = null;

        return view('admin.tag.tag_all', compact('tags', 'update', 'trashed'));
    }

    public function StoreTag(Request $request)
    {
        $locale = app()->getLocale();
        $request->validate(
            [
                'en_tag' => 'required',
                'la_tag' => 'required',
                'cn_tag' => 'required',
            ],
            [
                'en_tag' => $locale == 'en' ? 'Please enter tag'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຊື່ແທັກເປັນພາສາອັງກິດ'
                        : '请输入英文标签名称'),
                'la_tag' => $locale == 'en' ? 'Please enter tag name in Lao'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຊື່ແທັກເປັນພາສາລາວ'
                        : '请用老挝语输入标签名称'),
                'cn_tag' => $locale == 'en' ? 'Please enter tag name in Chinese'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຊື່ແທັກເປັນພາສາຈີນ'
                        : '请输入中文标签名称')
            ]
        );

        $valid_en = TagTranslation::where('name', strip_tags($request->en_tag))->where('locale', 'en')->first();
        $valid_la = TagTranslation::where('name', strip_tags($request->la_tag))->where('locale', 'la')->first();
        $valid_cn = TagTranslation::where('name', strip_tags($request->cn_tag))->where('locale', 'cn')->first();
        if ($valid_en || $valid_la || $valid_cn) {
            $notifiction = array(
                'message' =>
                $locale == 'en' ?
                    'This Tag Already have! Please try again!!' : ($locale == 'la' ? 'ຊື້ແທກຖືກນຳໃຊ້ແລ້ວ, ກະລຸນາລອງໃໝ່ອີກຄັ້ງ' : '此标签已被占用！ 请再试一次'),
                'alert-type' => 'error'
            );
            return back()->with($notifiction);
        }

        $tag = Tag::create([
            'user_id' => Auth::user()->id,
            'status' => 'true',
            'created_at' => Carbon::now(),
        ]);

        TagTranslation::insert([
            'name' => $request->en_tag,
            'slug' => strtolower(str_replace(' ', '-', $request->en_tag)),
            'locale' => $request->en_locale,
            'tag_id' => $tag->id,
        ]);

        TagTranslation::insert([
            'name' => $request->la_tag,
            'slug' => strtolower(str_replace(' ', '-', $request->la_tag)),
            'locale' => $request->la_locale,
            'tag_id' => $tag->id,
        ]);

        TagTranslation::insert([
            'name' => $request->cn_tag,
            'slug' => strtolower(str_replace(' ', '-', $request->cn_tag)),
            'locale' => $request->cn_locale,
            'tag_id' => $tag->id,
        ]);

        $notifiction = array(
            'message' =>
            $locale == 'en' ?
                'Creating Tag Successfully!!' : ($locale == 'la' ? 'ສ້າງແທັກສຳເລັດ!!' : '创建标签成功'),
            'alert-type' => 'success'
        );

        return back()->with($notifiction);
    }

    public function EditTag(Request $request)
    {
        $id = $request->id;
        $tags = Tag::withoutTrashed()->get();
        $trashed = Tag::onlyTrashed()->count();
        $en_tags = TagTranslation::where('tag_id', $id)->where('locale', 'en')->first();
        $la_tags = TagTranslation::where('tag_id', $id)->where('locale', 'la')->first();
        $cn_tags = TagTranslation::where('tag_id', $id)->where('locale', 'cn')->first();
        $update = 'true';
        return view('admin.tag.tag_all', compact(
            'tags',
            'en_tags',
            'la_tags',
            'cn_tags',
            'update',
            'trashed'
        ));
    }

    public function UpdateTag(Request $request)
    {
        $locale = app()->getLocale();
        $request->validate(
            [
                'en_tag' => 'required',
                'la_tag' => 'required',
                'cn_tag' => 'required',
            ],
            [
                'en_tag' => $locale == 'en' ? 'Please enter tag'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຊື່ແທັກເປັນພາສາອັງກິດ'
                        : '请输入英文标签名称'),
                'la_tag' => $locale == 'en' ? 'Please enter tag name in Lao'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຊື່ແທັກເປັນພາສາລາວ'
                        : '请用老挝语输入标签名称'),
                'cn_tag' => $locale == 'en' ? 'Please enter tag name in Chinese'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຊື່ແທັກເປັນພາສາຈີນ'
                        : '请输入中文标签名称')
            ]
        );

        $id = $request->id;
        $en_id = $request->en_id;
        $la_id = $request->la_id;
        $cn_id = $request->cn_id;
        $en_tag = strip_tags($request->en_tag);
        $la_tag = strip_tags($request->la_tag);
        $cn_tag = strip_tags($request->cn_tag);
        $valid_en = TagTranslation::where('name', $en_tag)->where('locale', 'en')->first();
        $valid_la = TagTranslation::where('name', $la_tag)->where('locale', 'la')->first();
        $valid_cn = TagTranslation::where('name', $cn_tag)->where('locale', 'cn')->first();

        if ($valid_en) {
            $db_en_id = $valid_en->id;
            if ($en_id != $db_en_id) {
                $notifiction = array(
                    'message' =>
                    $locale == 'en' ?
                        'This Tag Already have! Please try again!!'
                        : ($locale == 'la' ? 'ແທັກພາສາອັງກິດຖືກນຳໃຊ້ແລ້ວ! ກະລຸນາລອງໃໝ່ອີກຄັ້ງ' : '这个标签已经有了！ 请再试一次'),
                    'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        if ($valid_la) {
            $db_la_id = $valid_la->id;
            if ($la_id != $db_la_id) {
                $notifiction = array(
                    'message' =>
                    $locale == 'en' ? 'This Lao tag already have! Please try again!!'
                        : ($locale == 'la' ? 'ແທັກພາສາລາວຖືກນຳໃຊ້ແລ້ວ! ກະລຸນາລອງໃໝ່ອີກຄັ້ງ' : '这个老挝标签已经有了！ 请再试一次'),
                    'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }


        if ($valid_cn) {
            $db_cn_id = $valid_cn->id;
            if ($cn_id != $db_cn_id) {
                $notifiction = array(
                    'message' =>
                    $locale == 'en' ? 'This Chinese tag already have! Please try again!!'
                        : ($locale == 'la' ? 'ແທັກພາສາຈີນຖືກນຳໃຊ້ແລ້ວ! ກະລຸນາລອງໃໝ່ອີກຄັ້ງ' : '这个中文标签已经有了！ 请再试一次'),
                    'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        Tag::findOrFail($id)->update([
            'user_id' => Auth::user()->id,
        ]);

        TagTranslation::findOrFail($en_id)->update([
            'name' => $en_tag,
            'slug' => strtolower(str_replace(' ', '-', $en_tag)),
        ]);

        TagTranslation::findOrFail($la_id)->update([
            'name' => $la_tag,
            'slug' => strtolower(str_replace(' ', '-', $la_tag)),
        ]);

        TagTranslation::findOrFail($cn_id)->update([
            'name' => $cn_tag,
            'slug' => strtolower(str_replace(' ', '-', $cn_tag)),
        ]);

        $notifiction = array(
            'message' =>
            $locale == 'en' ? 'Update Tag Sucessfully!!'
            :($locale == 'la' ? 'ອັບເດດແທັກສຳເລັດ' : '更新标签成功'),
            'alert-type' => 'info'
        );

        return redirect()->route('tag')->with($notifiction);
    }

    public function DeleteTag(Request $request)
    {
        $id = $request->id;
        Tag::findOrFail($id)->delete();
        $notifiction = array(
            'message' => 'Deleted Tag Sucessfully!!', 'alert-type' => 'danger'
        );
        return back()->with($notifiction);
    }

    public function index(Request $request)
    {
        $trashed = Tag::onlyTrashed()->get();
        return view('admin.tag.tag_trash', compact('trashed'));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        Tag::where('id', $id)->withTrashed()->restore();
        $notifiction = array(
            'message' => 'Restore Tag Sucessfully!!', 'alert-type' => 'success'
        );
        return redirect()->route('tag')->with($notifiction);
    }

    public function force_delete(Request $request)
    {
        $id = $request->id;
        Tag::where('id', $id)->withTrashed()->forceDelete();
        $notifiction = array(
            'message' => 'Deleted Tag Sucessfully!!', 'alert-type' => 'danger'
        );
        // return redirect()->route('tag')->with($notifiction);
        return back()->with($notifiction);
    }
}
