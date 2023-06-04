<?php

namespace App\Http\Controllers;

use App\Models\Socialmedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SocialmediaController extends Controller
{
    public function index()
    {
        $social = Socialmedia::all();
        return view('admin.company.social_media', compact('social'));
    }

    public function store(Request $request)
    {
        $media_type = $request->name;
        $request->validate([
            'name' => 'required',
            'icon' => 'required',
            'color' => 'required',
            'url' => 'required'
        ]);

        $icon = $request->icon;
        $replace1 = str_replace('<i class="', "",  $icon);
        $replace2 = str_replace('"></i>', "",  $replace1);
        $real_icon = $replace2;

        if ($media_type == "Phone") {
            if (preg_match('/[^0-9]/', $request->url)) {
                $notifiction = array(
                    'message' => 'Phone number invalid!', 'alert-type' => 'error'
                );
                return redirect()->back()->with($notifiction);
            } else {
                if (str_starts_with($request->url, '020') && strlen($request->url) == 11) {
                    $url = "tel:" . $request->url;
                } elseif (str_starts_with($request->url, '20') && strlen($request->url) == 10) {
                    $url = "tel:0" . $request->url;
                } elseif (!str_starts_with($request->url, '0') && strlen($request->url) == 8) {
                    $url = "tel:020" . $request->url;
                } else {
                    $notifiction = array(
                        'message' => 'Phone number invalid!', 'alert-type' => 'error'
                    );
                    return redirect()->back()->with($notifiction);
                }
            }
        } elseif ($media_type == "Whatsapp") {
            if (preg_match('/[^0-9]/', $request->url)) {
                $notifiction = array(
                    'message' => 'Phone number invalid!', 'alert-type' => 'error'
                );
                return redirect()->back()->with($notifiction);
            } else {
                if (str_starts_with($request->url, '020') && strlen($request->url) == 11) {
                    $replace_url = str_replace('020', "", $request->url);
                    $url = "https://wa.me/" . "+85620" . $replace_url . "?text=I'm%20interested%20in%20your%20service";
                } elseif (str_starts_with($request->url, '20') && strlen($request->url) == 10) {
                    $url = "https://wa.me/" . "+856" . $request->url . "?text=I'm%20interested%20in%20your%20service";
                } elseif (!str_starts_with($request->url, '0') && strlen($request->url) == 8) {
                    $url = "https://wa.me/" . "+85620" .  $request->url . "?text=I'm%20interested%20in%20your%20service";
                } else {
                    $notifiction = array(
                        'message' => 'Phone number invalid!', 'alert-type' => 'error'
                    );
                    return redirect()->back()->with($notifiction);
                }
            }
        } elseif ($media_type == "Facebook") {
            if (str_starts_with($request->url, 'https://www.facebook.com/')) {
                $url = $request->url;
            } else {
                $url = "https://www.facebook.com/" . $request->url;
            }
        } elseif ($media_type == "Line") {
            if (str_starts_with($request->url, 'https://line.me/ti/p/')) {
                $url = $request->url;
            } else {
                $notifiction = array(
                    'message' => 'Invalid line!', 'alert-type' => 'error'
                );
                return redirect()->back()->with($notifiction);
            }
        }

        $data = $request->all();
        $social = new Socialmedia();
        if ($data) {
            $query = Socialmedia::where('name', $request->social)->doesntExist();
            if ($query) {
                $social->user_id = Auth::user()->id;
                $social->name = strip_tags($request->name);
                $social->url = $url;
                $social->icon = $real_icon;
                $social->color = $request->color;
                $social->save();

                $notifiction = array(
                    'message' => 'Insert success', 'alert-type' => 'success'
                );
                return redirect()->back()->with($notifiction);
            } else {
                $notifiction = array(
                    'message' => 'Data Already used', 'alert-type' => 'error'
                );
                return redirect('create/social')->with("success", "insert success");
            }
        } else {
            $notifiction = array(
                'message' => 'data is required', 'alert-type' => 'error'
            );
            return redirect()->back()->with($notifiction);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $social = Socialmedia::findOrFail($id);
        return view('admin.company.social_update', compact('social'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = DB::table("socialmedia")->where('id', $id)->get();
        $icon = $request->icon;
        $replace1 = str_replace('<i class="', "",  $icon);
        $replace2 = str_replace('"></i>', "",  $replace1);
        $real_icon = $replace2;

        if ($data) {
            $social = SocialMedia::find($id);

            $social->name = strip_tags($request->name);
            $social->url = $request->url;
            $social->icon = $real_icon;
            $social->color = $request->color;
        }

        $social->update();
        $notifiction = array(
            'message' => 'update success', 'alert-type' => 'success'
        );
        return redirect()->route('index.social')->with($notifiction);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        SocialMedia::findOrFail($id)->delete();
        $notifiction = array(
            'message' => 'delete success', 'alert-type' => 'success'
        );
        return redirect()->back()->with($notifiction);
    }
}
