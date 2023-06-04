<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\Response;
use App\Http\Controllers\CleanTextController;

class RoleController extends Controller
{
    public function AllPermission()
    {
        $permissions = Permission::all();
        return view('roles_and_permissions.permission.all_permission', compact('permissions'));
    } //end method


    public function AddPermission()
    {
        return view('roles_and_permissions.permission.add_permission');
    } //end method


    public function StorePermission(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'group_name' => 'required'
        ], [
            'name' => 'Please Enter The Permission Name',
            'group_name' => 'Please Select Group Name',
        ]);
        $role = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array('message' => 'Permission Inserted Successfully', 'alert-type' => 'success');
        return redirect()->route('all.permission')->with($notification);
    } //end method


    public function EditPermission(Request $request)
    {
        $id = $request->id;
        $permission = Permission::findOrFail($id);
        return view('roles_and_permissions.permission.edit_permission', compact('permission'));
    } //end method


    public function UpdatePermission(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'group_name' => 'required'
        ], [
            'name' => 'Please Enter The Permission Name',
            'group_name' => 'Please Select Group Name',
        ]);
        $per_id = $request->id;
        Permission::findOrFail($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array('message' => 'Permission Update Successfully', 'alert-type' => 'success');
        return redirect()->route('all.permission')->with($notification);
    } //end method


    public function DeletePermission(Request $request)
    {
        $id = $request->id;
        Permission::findOrFail($id)->delete();
        $notification = array('message' => 'Permission Deleted Successfully', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    } //end method



    /////////All Roles;/////

    public function AllRoles()
    {
        $roles = Role::all();
        return view('roles_and_permissions.roles.all_roles', compact('roles'));
    } //end method


    public function AddRoles()
    {
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        return view('roles_and_permissions.roles.add_roles');
    } //end method


    public function StoreRoles(Request $request)
    {
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        $request->validate(['name' => 'required'], ['name' => 'Please Enter The Role Name']);

        $cleanData = strip_tags($request->name);

        $valid = Role::where('name', $cleanData)->first();
        if ($valid) {
            $notifiction = array(
                'message' => 'This User Already have! Please try again!!', 'alert-type' => 'error'
            );
            return back()->with($notifiction);
        }

        $role = Role::create(['name' => $cleanData]);
        $notification = array('message' => 'Roles Inserted Successfully', 'alert-type' => 'success');
        return redirect()->route('all.roles')->with($notification);
    } //end method



    public function EditRoles(Request $request)
    {
        $id = $request->id;
        $roles = Role::findOrFail($id);
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        return view('roles_and_permissions.roles.edit_roles', compact('roles'));
    } //end method



    public function UpdateRoles(Request $request)
    {
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        $request->validate(['name' => 'required'], ['name' => 'Please Enter The Role Name']);
        $role_id = $request->id;
        $cleanData = strip_tags($request->name);
        $valid = Role::where('name', $cleanData)->first();
        if ($valid) {
            $db_id = $valid->id;
            if ($role_id != $db_id) {
                $notifiction = array(
                    'message' => 'This User Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        Role::findOrFail($role_id)->update(['name' => $cleanData]);
        $notification = array('message' => 'Roles Updated Successfully', 'alert-type' => 'success');
        return redirect()->route('all.roles')->with($notification);
    } //end method



    public function DeleteRoles(Request $request)
    {
        $id = $request->id;
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        Role::findOrFail($id)->delete();
        $notification = array('message' => 'Roles Deleted Successfully', 'alert-type' => 'success');
        return redirect()->route('all.roles')->with($notification);
    } //end method


    //Add Role Permission


    public function AddRolesPermission()
    {
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('roles_and_permissions.roles.add_roles_permission', compact('roles', 'permissions', 'permission_groups'));
    } //end method


    public function RolePermissionStore(Request $request)
    {
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        $request->validate(['role_id' => 'required'], ['role_id' => 'Please Select Role Name']);
        $data = array();
        $permissions = $request->permission;

        foreach ($permissions as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        }
        $notification = array('message' => 'Roles Permission Added Successfully', 'alert-type' => 'success');
        return redirect()->route('all.roles.permission')->with($notification);
    } //end method


    public function AllRolesPermission()
    {
        $roles = Role::all();
        return view('roles_and_permissions.roles.all_roles_permission', compact('roles'));
    } //end method


    public function AdminRoleEdit(Request $request)
    {
        $id = $request->id;
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('roles_and_permissions.roles.role_permission_edit', compact('role', 'permissions', 'permission_groups'));
    } //end method



    public function AdminRolesUpdate(Request $request)
    {
        $id = $request->id;

        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        $role = Role::findOrFail($id);
        $permissions = $request->permission;

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }
        $notification = array('message' => 'Roles Permission Updated Successfully', 'alert-type' => 'success');
        return redirect()->route('all.roles.permission')->with($notification);
    } //end method



    public function AdminDeleteRoles(Request $request)
    {
        $id = $request->id;
        Gate::allows('isAdmin') ? Response::allow() : abort(403);
        $role = Role::findOrFail($id);
        if (!is_null($role)) {
            $role->delete();
        }
        $notification = array('message' => 'Roles Permission Deleted Successfully', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    } //end method





}
