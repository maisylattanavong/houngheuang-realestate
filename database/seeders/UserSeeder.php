<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //user seeder
        $superuser=User::create([
            'name' => 'SuperAdmin',
            'email' => 'superuser@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => '1',
            'status'=>'1',
        ]);
        //user seeder
        $admin=User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => '1',
            'status'=>'1',
        ]);
        //user seeder
        $user=User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => '0',
            'status'=>'1',
        ]);

        //asign role to superuser
        $superuser->assignRole('super-user');
        //asign role to admin
        $admin->assignRole('admin');
        //asign role to user
        $user->assignRole('user');
    }
}

