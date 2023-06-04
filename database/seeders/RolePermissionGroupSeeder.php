<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //rolepermission
        $rolepermissions = [
            'role.menu',
            'role.list',
            'role.add',
            'role.edit',
            'role.delete',
            'role.permission.list',
            'role.permission.add',
            'role.permission.edit',
            'role.permission.delete',
        ];
        foreach ($rolepermissions as $permission) {
            Permission::create(['name' => $permission, 'group_name' => 'role']);
        }
        //adminpermission
        $adminpermissions = [
            'userManage.menu',
            'user.list',
            'user.add',
            'user.edit',
            'user.soft.delete',
            'user.restore.delete',
            'user.force.delete',
            'user.role.list',
            'user.role.add',
            'user.role.edit',
            'user.role.soft.delete',
            'user.role.restore.delete',
            'user.role.force.delete',
            'user.active',
        ];
        foreach ($adminpermissions as $permission) {
            Permission::create(['name' => $permission, 'group_name' => 'admin']);
        }

        //permission
        // $permissions = [
        //     'permission.menu',
        //     'permission.list',
        //     'permission.add',
        //     'permission.edit',
        //     'permission.delete',
        // ];
        // foreach ($permissions as $permission) {
        //     Permission::create(['name' => $permission, 'group_name' => 'permission']);
        // }


        //post
        $propertypermissions = [
            // 'post.menu',
            // 'post.list',
            // 'post.add',
            // 'post.edit',
            // 'post.soft.delete',
            // 'post.restore.delete',
            // 'post.force.delete',
            'property.menu',
            'property.list',
            'property.add',
            'property.edit',
            'property.soft.delete',
            'property.restore.delete',
            'property.force.delete',
            'category.menu',
            'category.insert',
            'category.edit',
            'category.soft.delete',
            'category.restore.delete',
            'category.force.delete',
            'tag.menu',
            'tag.insert',
            'tag.edit',
            'tag.soft.delete',
            'tag.restore.delete',
            'tag.force.delete',
        ];
        foreach ($propertypermissions as $permission) {
            Permission::create(['name' => $permission, 'group_name' => 'property']);
        }
        //aboutpage
        // $aboutpagepermissions = [
        //     'aboutPage.menu',
        //     'aboutPage.update',
        // ];
        // foreach ($aboutpagepermissions as $permission) {
        //     Permission::create(['name' => $permission, 'group_name' => 'aboutPage']);
        // }
        //sitesetting
        $sitesettingpermissions = [
            'siteSetting.menu',
            'siteInfo.menu',
            'siteInfo.insert',
            'siteInfo.edit',
            'guide.menu',
            'guide.insert',
            'guide.edit',
            // 'bannerSlide.menu',
            // 'bannerSlide.add',
            // 'bannerSlide.onOff',
            // 'bannerSlide.edit',
            // 'bannerSlide.soft.delete',
            // 'bannerSlide.restore.delete',
            // 'bannerSlide.force.delete',
            'socialMedia.menu',
            'socialMedia.insert',
            'socialMedia.edit',
            'socialMedia.delete',
        ];
        foreach ($sitesettingpermissions as $permission) {
            Permission::create(['name' => $permission, 'group_name' => 'siteSetting']);
        }

        //Project Design
        // $projectDesign = [
        //     'projectDesign.menu',
        //     'projectDesign.list',
        //     'projectDesign.add',
        //     'employee.add',
        // ];
        // foreach ($projectDesign as $permission) {
        //     Permission::create(['name' => $permission, 'group_name' => 'projectDesign']);
        // }

        //Media
        $media = [
            'media.menu',
        ];
        foreach ($media as $permission) {
            Permission::create(['name' => $permission, 'group_name' => 'media']);
        }


        //assign permission to role
        $role = Role::create(['name' => 'super-user']);
        $role->givePermissionTo(
            $rolepermissions,
            $adminpermissions,
            // $permissions,
            $propertypermissions,
            // $aboutpagepermissions,
            $sitesettingpermissions,
            // $projectDesign,
            $media,
        );
        Role::create(['name' => 'admin']);

        $userrole = Role::create(['name' => 'user']);
        $userpermission = ['N/A'];
        Permission::create(['name' => 'N/A', 'group_name' => 'N/A']);
        $userrole->givePermissionTo($userpermission);
    }
}
