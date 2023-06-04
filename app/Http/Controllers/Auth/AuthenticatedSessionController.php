<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $status = $request->status;
        return view('auth.login', compact('status'));
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $url = '';
        if($request->user()->role === '1'){
            $url = 'admin/all/roles/permission';
            $notification = array('message' => 'User Login Successfully', 'alert-type' => 'success');
            return redirect()->intended($url)->with($notification);
        } else {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $notification = array('message'=>'You do not have permission to login', 'alert-type'=>'warning');
            return redirect()->route('login')->with($notification);
        }
        // return redirect()->intended(RouteServiceProvider::HOME)->with($notification);

    }

    public function StatusLogin(LoginRequest $request, $status)
    {
        dd($request);
        dd($status);
    }


    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
