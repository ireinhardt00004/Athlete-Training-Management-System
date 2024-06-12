<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'student_num' => '',
            'name' => 'John M. Doe',
            'lname' => 'Doe',
            'middlename' => 'M',
            'fname' => 'John',
            'course' => '',
            'gender' => 'Male',
            'roles' => 'admin',
            'email' => 'admin.athlete@cvsu.edu.ph',
            'email_verified_at' => now(),
            'password' => Hash::make('789456123'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // You can add more users as needed.
    }
}
