<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@presensi.test',
            'password' => Hash::make('admin123'),
            'role_id' => 1, // admin
            'is_active' => true,
        ]);
    }
}
