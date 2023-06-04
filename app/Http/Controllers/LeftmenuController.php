<?php

namespace App\Http\Controllers;

use App\Models\Leftmenu;
use Illuminate\Http\Request;

class LeftmenuController extends Controller
{
    public function index()
    {   
        $leftmenus = Leftmenu::where('parent_id', 0)->get();
        $allleftmenu = Leftmenu::pluck('title', 'id')->all();
        return view('admin.leftmenu.index', compact('leftmenus', 'allleftmenu'));
    }
    //strore menu
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'icons' => 'required',
        ]);
        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        Leftmenu::create($input);
        return back()->with('success', 'Left menu Added Successfully');
    }
    //show menu
    public function show()
    {
        $leftmenus = Leftmenu::where('parent_id', '=',0)->get();
        dd($leftmenus);
        return view('admin.leftmenu.showleftmenu', compact('leftmenus'));
    }
}
