<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // profile view
    public function Profile()
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view', compact('adminData'));
    }

    public function EditProfile()
    {
        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('admin.admin_profile_edit', compact('editData'));
    }

    public function StoreProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required'],
        ], [
            'name' => 'Please Enter the Name',
            'email' => 'Email can not be blank'
        ]);

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = strip_tags($request->name);

        $old_profile_image = $request->old_image;

        if ($data->email == $request->email) {
            $data->email = $request->email;
            if ($request->file('profile_image')) {

                $request->validate([
                    'profile_image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
                ], [
                    'profile_image' => 'Please choose file image, ex: jpeg, png, jpg, gif, svg file size must be smaller than 2MB',
                ]);

                $file = $request->file('profile_image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $save_url = public_path('storage/media/' . $filename);

                $img = Image::make($file->getRealPath());
                $img->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);


                $data['profile_image'] = $filename;
                if ($request->old_image && file_exists('storage/media/' . $old_profile_image)) {
                    unlink('storage/media/' . $old_profile_image);
                }
            }
            $data->save();
            $notification = array('message' => 'Profile Updated Successfully', 'alert-type' => 'info');
            return redirect()->route('admin.profile')->with($notification);
        } else {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            ], [
                'email' => 'This email is already token, try choose new email'
            ]);

            $data->email = $request->email;

            if ($request->file('profile_image')) {
                $request->validate([
                    'profile_image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
                ], [
                    'profile_image' => 'Please choose file image, ex: jpeg, png, jpg, gif, svg file size must be smaller than 2MB',
                ]);


                $file = $request->file('profile_image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $save_url = public_path('storage/media/' . $filename);

                $img = Image::make($file->getRealPath());
                $img->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);

                $data['profile_image'] = $filename;
                if ($request->old_image && file_exists('storage/media/' . $old_profile_image)) {
                    unlink('storage/media/' . $old_profile_image);
                }
            }
            $data->save();
            $notification = array('message' => 'Profile Updated Successfully', 'alert-type' => 'info');
            return redirect()->route('admin.profile')->with($notification);
        }
    } //end method


    public function ChangePassword()
    {
        return view('admin.admin_change_password');
    }

    public function UpdatePassword(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => [
                'required',
            ],
            'confirm_password' => 'required|same:newpassword'
        ]);
        $request->validate([
            'newpassword' => [
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@$!%*#?&^&=]).*$/',
            ],
        ], [
            'newpassword' => 'Password must be 8-16 characters long, and contain numbers, one uppercase, one lowercase and special character. ex: Tq#12345',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            // session()->flash('message', 'Password Updated Successfully');
            // return redirect()->back();
            $notification = array('message' => 'Password Changed Successfully', 'alert-type' => 'success');
            return redirect()->route('admin.profile')->with($notification);
        } else {
            // session()->flash('message', 'Old Password is not match');
            $notification = array('message' => 'Old password is not match', 'alert-type' => 'warning');
            return redirect()->back()->with($notification);
        }
    } //end method


    // Admin All method
    public function AllAdmin()
    {
        // $alladminuser = User::latest()->get();
        $alladminuser = User::withoutTrashed()->get();
        $trashed = User::onlyTrashed()->count();
        return view('roles_and_permissions.admin.all_admin', compact('alladminuser', 'trashed'));
    } // end method

    public function AddAdmin()
    {
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        $roles = Role::all();
        return view('roles_and_permissions.admin.add_admin', compact('roles'));
    } //end

    public function AdminUserStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',

            'confirm_password' => 'required|same:password',
            'profile_image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
            'roles' => 'required'
        ], [
            'name' => 'Please Enter the Name',
            'email' => 'Please enter your email',
            'profile_image' => 'Please choose an image and file size must be smaller than 2MB',
            'roles' => 'Please Asign Roles'
        ]);

        $request->validate([
            'email' => ['string', 'email', 'max:255', 'unique:' . User::class],
            'password' => [
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@$!%*#?&^&=]).*$/',
            ],
            'profile_image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
        ], [
            'email' => 'This email is already exist, try new email',
            'password' => 'Password must be 8-16 characters long, and contain numbers, one uppercase, one lowercase and special character. ex: Tq#12345',
            'profile_image' => 'Please choose file image, ex: jpeg, png, jpg, gif, svg and file size must be smaller than 2MB'

        ]);

        $image = $request->file('profile_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        $save_url = public_path('storage/media/' . $name_gen);
        $img = Image::make($image->getRealPath());
        $img->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        })->save($save_url);

        $user = new User();
        $user->name = strip_tags($request->name);
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->profile_image = $name_gen;
        $user->role = 1;
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'New Admin User Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification);
    } //end method

    public function EditAdminRole(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        $roles = Role::all();
        return view('roles_and_permissions.admin.edit_admin', compact('user', 'roles'));
    } //end method

    public function AdminUserUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'roles' => 'required'
        ], [
            'name' => 'Please Enter the Name',
            'email' => 'Email can not be blank',
            'roles' => 'Please Asign Roles',
        ]);
        $id = $request->id;

        if ($request->password) {
            $request->validate([
                'password' => [
                    'min:8',
                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@$!%*#?&^&=]).*$/',
                ],
                'confirm_password' => 'required|same:password',
            ], [
                'password' => 'Password must be 8-16 characters long, and contain numbers, one uppercase, one lowercase and special character. ex: Tq#12345',
                'confirm_password' => 'Confirm password and password must match',
            ]);
        }

        $old_password = (empty($request->password)) ? $request->old_password : Hash::make($request->password);
        $old_image = $request->old_image;
        $data = User::findOrFail($id);
        $data->name = strip_tags($request->name);
        $data->role = 1;
        $data->password = $old_password;
        if ($data->email == $request->email) {
            $data->email = $request->email;
            if ($request->file('profile_image')) {

                $request->validate([
                    'profile_image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
                ], [
                    'profile_image' => 'Please choose file image, ex: jpeg, png, jpg, gif, svg and file size must be smaller than 2MB'
                ]);


                $file = $request->file('profile_image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $save_url = public_path('storage/media/' . $filename);

                $img = Image::make($file->getRealPath());
                $img->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);

                // $file->move(public_path('storage/media'), $filename);
                $data['profile_image'] = $filename;
                if ($request->old_image && file_exists('storage/media/' . $old_image)) {
                    unlink('storage/media/' . $old_image);
                }
            }

            $data->save();

            $data->roles()->detach();
            if ($request->roles) {
                $data->assignRole($request->roles);
            }

            $notification = array('message' => 'User Updated with Image Successfully', 'alert-type' => 'info');
            return redirect()->route('all.admin')->with($notification);
        } else {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            ], [
                'email' => 'This email is already token, try choose new email'
            ]);

            $data->email = $request->email;

            if ($request->file('profile_image')) {

                $request->validate([
                    'profile_image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
                ], [
                    'profile_image' => 'Please choose file image, ex: jpeg,png,jpg,gif,svg and file size must be smaller than 2MB'
                ]);


                $file = $request->file('profile_image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $save_url = public_path('storage/media/' . $filename);

                $img = Image::make($file->getRealPath());
                $img->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);

                $data['profile_image'] = $filename;
                if ($request->old_image && file_exists('storage/media/' . $old_image)) {
                    unlink('storage/media/' . $old_image);
                }
            }

            $data->save();

            $data->roles()->detach();
            if ($request->roles) {
                $data->assignRole($request->roles);
            }

            $notification = array('message' => 'New Admin User Updated Without Image Successfully', 'alert-type' => 'info');
            return redirect()->route('all.admin')->with($notification);
        }
    } //end method



    public function DeleteAdminRole(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        if (!is_null($user)) {
            $user->delete();
        }
        $notification = array('message' => 'Admin User Deleted Without Image Successfully', 'alert-type' => 'info');
        return redirect()->back()->with($notification);
    } //end method

    public function trash(Request $request)
    {
        $trashed = User::onlyTrashed()->get();
        return view('roles_and_permissions.admin.trash_admin', compact('trashed'));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        User::where('id', $id)->withTrashed()->restore();
        $notifiction = array(
            'message' => 'Restore User Sucessfully!!', 'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notifiction);
    }

    public function force_delete(Request $request)
    {
        $id = $request->id;
        $user = DB::table('users')->where('id', $id)->first();
        $image = $user->profile_image;
        User::where('id', $id)->withTrashed()->forceDelete();
        $notifiction = array(
            'message' => 'Deleted User Sucessfully!!', 'alert-type' => 'danger'
        );

        if (file_exists('pubic/storage/media/' . $image)) {
            unlink('public/storage/media/' . $image);
        }

        return back()->with($notifiction);
    }

    //--------Admin Logout---------------------------
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $notification = array('message' => 'User Logout Successfully', 'alert-type' => 'success');
        // return redirect('/admin')->with($notification);
        return redirect()->route('login')->with($notification);
    } //end method


    public function Login()
    {
        $status = 0;
        return view('auth.login', compact('status'));
    } //end method

    public function AdminLogin(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $url = '';
        if ($request->user()->role === '1') {
            if ($request->has('remember')) {
                Cookie::queue('email', $request->email, 1440);
                Cookie::queue('password', $request->password, 1440);
            } else {
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('password'));
                // return response();

            }
            $url = app()->getLocale() . '/admin/dashboard';
            $notification = array('message' => 'User Login Successfully', 'alert-type' => 'success');
            return redirect()->route('dashboard')->with($notification);
        }
        if ($request->user()->role === '0') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $notification = array('message' => 'No Permission to Login !', 'alert-type' => 'warning');
            return redirect()->route('index.page')->with($notification);
        }
    } //end method


    public function StatusLogin($id)
    {
        $status = $id;
        return view('auth.login', compact('status'));
    }

    public function AdminStatusLogin(LoginRequest $request)
    {
        // dd($request->status, gettype($request->status));
        $request->authenticate();
        $request->session()->regenerate();
        $url = '';
        if ($request->user()->role === '1') {
            if ($request->has('remember')) {
                Cookie::queue('email', $request->email, 1440);
                Cookie::queue('password', $request->password, 1440);
            } else {
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('password'));
            }
            $notification = array('message' => 'User Login Successfully', 'alert-type' => 'success');

            if ($request->status == "5") {
                return redirect()->route('category');
            } else if ($request->status == "1") {
                return redirect()->route('create.post');
            } else if ($request->status == "2") {
                return redirect()->route('about.page');
            } else if ($request->status == "3") {
                return redirect()->route('create.companyLogo');
            } else {
                return redirect()->route('dashboard')->with($notification);
            }
        }
        if ($request->user()->role === '0') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $notification = array('message' => 'No Permission to Login !', 'alert-type' => 'warning');
            return redirect()->route('index.page')->with($notification);
        }
    } //end method status login


    public function ActiveAdminStatus(Request $request)
    {
        $id = $request->id;
        $data = User::findOrFail($id);
        // $status = $data->status == 'active' ? 'inactive' : 'active';
        // dd($status);
        if ($data->status == '1') {
            $data->status = '0';
            $data->role = '0';
            $data->save();
            $notification = array('message' => 'Status Inactive successfully', 'alert-type' => 'warning');
            return redirect()->back()->with($notification);
        } elseif ($data->status == '0') {
            $data->status = '1';
            $data->role = '1';
            $data->save();
            $notification = array('message' => 'Status Active successfully', 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }
    } //end method


    






}
