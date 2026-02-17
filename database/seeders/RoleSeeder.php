<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'description' => 'Administrator Sistem',
            ],
            [
                'name' => 'hrd',
                'description' => 'Human Resource Department',
            ],
            [
                'name' => 'finance',
                'description' => 'Bagian Keuangan',
            ],
            [
                'name' => 'karyawan',
                'description' => 'Karyawan',
            ],
        ]);
    }
}
