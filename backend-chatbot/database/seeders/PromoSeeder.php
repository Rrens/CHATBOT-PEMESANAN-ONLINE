<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promos')->insert([
            [
                'id_menu' => 1,
                'name' => 'Hari Raya',
                'discount' => 20
            ],
            [
                'id_menu' => 2,
                'name' => 'Hari Raya',
                'discount' => 30
            ],
            [
                'id_menu' => 3,
                'name' => 'Hari Raya',
                'discount' => 30
            ],
            [
                'id_menu' => 4,
                'name' => 'Hari Raya',
                'discount' => 30
            ],
            [
                'id_menu' => 5,
                'name' => 'Hari Raya',
                'discount' => 30
            ],
            [
                'id_menu' => 6,
                'name' => 'Hari Raya',
                'discount' => 30
            ],
            [
                'id_menu' => 7,
                'name' => 'Hari Raya',
                'discount' => 30
            ],
            [
                'id_menu' => 8,
                'name' => 'Hari Raya',
                'discount' => 30
            ],
            [
                'id_menu' => 9,
                'name' => 'Hari Raya',
                'discount' => 30
            ],
            [
                'id_menu' => 10,
                'name' => 'Hari Raya',
                'discount' => 30
            ],
        ]);
    }
}
