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
            [
                'name' => 'sambal bakar',
                'price' => '35000',
                'stock' => '230',
            ],
            [
                'name' => 'sambal teri',
                'price' => '30000',
                'stock' => '130',
            ],
            [
                'name' => 'sambal mangga',
                'price' => '25000',
                'stock' => '130',
            ],
            [
                'name' => 'sambal terasi',
                'price' => '30000',
                'stock' => '230',
            ],
            [
                'name' => 'sambal bajak',
                'price' => '25000',
                'stock' => '150',
            ],
            [
                'name' => 'sambal Matah"',
                'price' => '30000',
                'stock' => '200',
            ],
            [
                'name' => 'sambal Tomat',
                'price' => '25000',
                'stock' => '220',
            ],
            [
                'name' => 'sambal Roa',
                'price' => '32000',
                'stock' => '230',
            ],
            [
                'name' => 'sambal ulek',
                'price' => '26000',
                'stock' => '200',
            ],
        ]);
    }
}
