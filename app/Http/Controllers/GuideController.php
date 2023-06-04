<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\GuideTranslation;
use Illuminate\Support\Facades\Auth;

class GuideController extends Controller
{
    public function index()
    {
        // $content = Guide::all();
        // dd($content);
        return view('admin.guide.create',);
    }


    public function store(Request $request)
    {
        $locale = app()->getLocale();
        $request->validate(
            [
                'en_content' => 'required',
                'la_content' => 'required',
                'cn_content' => 'required',
            ],
            [
                'en_content' => $locale == 'en' ? 'Please enter content detail in English'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຂໍ້ມູນເປັນພາສາອັງກິດ'
                        : '请用英文输入详细内容'),
                'la_content' => $locale == 'en' ? 'Please enter content detail in Lao'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຂໍ້ມູນເປັນພາສາລາວ'
                        : '请用老挝语输入详细内容'),
                'cn_content' => $locale == 'en' ? 'Please enter content detail in Chinese'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຂໍ້ມູນເປັນພາສາຈີນ'
                        : '请用中文输入详细内容'),
            ]
        );
        $content = Guide::create([
            'user_id' => Auth::user()->id,
        ]);

        GuideTranslation::insert([
            'guide_id' => $content->id,
            'locale' => 'en',
            'content' => $request->en_content,
        ]);
        GuideTranslation::insert([
            'guide_id' => $content->id,
            'locale' => 'la',
            'content' => $request->la_content,
        ]);
        GuideTranslation::insert([
            'guide_id' => $content->id,
            'locale' => 'cn',
            'content' => $request->cn_content,
        ]);
        $notification = array(
            'message' => 'Insert Successfully', 'alert-type' => 'success'
        );

        return redirect()->route('guide.edit')->with('notification');
    }


    public function edit()
    {
        $en_content = GuideTranslation::where('locale', 'en')->first();
        $la_content = GuideTranslation::where('locale', 'la')->first();
        $cn_content = GuideTranslation::where('locale', 'cn')->first();

        // dd($content->id);
        return view('admin.guide.edit', compact('en_content', 'la_content', 'cn_content'));
    }



    public function update(Request $request)
    {
        $locale = app()->getLocale();
        $request->validate(
            [
                'en_content' => 'required',
                'la_content' => 'required',
                'cn_content' => 'required',
            ],
            [
                'en_content' => $locale == 'en' ? 'Please enter content detail in English'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຂໍ້ມູນເປັນພາສາອັງກິດ'
                        : '请用英文输入详细内容'),
                'la_content' => $locale == 'en' ? 'Please enter content detail in Lao'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຂໍ້ມູນເປັນພາສາລາວ'
                        : '请用老挝语输入详细内容'),
                'cn_content' => $locale == 'en' ? 'Please enter content detail in Chinese'
                    : ($locale == 'la' ? 'ກະລຸນາປ້ອນຂໍ້ມູນເປັນພາສາຈີນ'
                        : '请用中文输入详细内容')
            ]
        );

        $content = Guide::findOrFail($request->guide_id)->update([
            'user_id'=>Auth::user()->id,
            'updated_at'=>Carbon::now()
        ]);


        GuideTranslation::findOrFail($request->en_id)->update([
            'locale'=>'en',
            'content'=>$request->en_content,
        ]);
        GuideTranslation::findOrFail($request->la_id)->update([
            'locale'=>'la',
            'content'=>$request->la_content,
        ]);
        GuideTranslation::findOrFail($request->cn_id)->update([
            'locale'=>'cn',
            'content'=>$request->cn_content,
        ]);

        $notification = array(
            'message' => 'Update Successfully', 'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
