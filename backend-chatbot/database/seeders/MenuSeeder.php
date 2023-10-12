<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            [
                'name' => 'sambal ijo',
                'price' => '30000',
                'stock' => '110',
            ],
            [
                'name' => 'sambal cumi',
                'price' => '32000',
                'stock' => '100',
            ],
        ]);
    }
}
