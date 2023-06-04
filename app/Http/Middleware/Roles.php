<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {

        // if($request->user()->role !== $roles){
        //     return redirect('admin/dashboard');
        // }

        if(Auth::user()->role !== $roles){
            return redirect('admin/dashboard');
        }

        // $roles = explode(',', $roles);
        // if(is_array($roles)){
        //     foreach($roles as $role){
        //         if($request->user()->role !== $role){
        //             return redirect('admin/dashboard');
        //         }
        //     }
        // }

        return $next($request);
    }
}
