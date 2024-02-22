<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'role' => 'superadmin'
            ],
            [
                'name' => 'admin order',
                'email' => 'admin-order@admin.com',
                'password' => Hash::make('admin'),
                'role' => 'admin_order'
            ],
            [
                'name' => 'admin konten',
                'email' => 'admin-konten@admin.com',
                'password' => Hash::make('admin'),
                'role' => 'admin_konten'
            ],
        ]);
    }
}
