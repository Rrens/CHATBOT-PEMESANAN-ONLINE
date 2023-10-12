<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'whatsapp' => '6281993888193',
                'is_block' => 0,
                'is_distributor' => 1,
                'request_distributor' => 0,
            ],
            [
                'whatsapp' => '6281993813993',
                'is_block' => 1,
                'is_distributor' => 1,
                'request_distributor' => 0,
            ],
            [
                'whatsapp' => '6281993893881',
                'is_block' => 0,
                'is_distributor' => 0,
                'request_distributor' => 0,
            ],
            [
                'whatsapp' => '628391992900',
                'is_block' => 1,
                'is_distributor' => 0,
                'request_distributor' => 1,
            ]
        ]);
    }
}
