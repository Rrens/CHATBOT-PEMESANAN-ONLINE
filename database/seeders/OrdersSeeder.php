<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'id' => 698223680,
                'id_customer' => 5,
                'resi_number' => 18022470553,
                'courier' => 'pos',
                'address' => 'gubeng raya indo no.9',
                'zipcode' => '728939',
                'status' => 1,
                'link' => 'https://app.sandbox.midtrans.com/snap/v3/redirection/c1cfa651-6af7-4eea-aae3-52f4242d3619',
                'created_at' => '2023-10-25 08:47:59',
            ],
            [
                'id' => 698223987,
                'id_customer' => 6,
                'resi_number' => 18022470553,
                'courier' => 'pos',
                'address' => 'gubeng raya indo no.9',
                'zipcode' => '728939',
                'status' => 0,
                'link' => 'https://app.sandbox.midtrans.com/snap/v3/redirection/c1cfa651-6af7-4eea-aae3-52f4242d3619',
                'courier' => 'pos',
                'created_at' => '2023-10-25 08:53:06',
            ],
            [
                'id' => 698227072,
                'id_customer' => 5,
                'resi_number' => 18022470553,
                'courier' => 'pos',
                'address' => 'gubeng raya indo no.9',
                'zipcode' => '728939',
                'status' => 1,
                'link' => 'https://app.sandbox.midtrans.com/snap/v3/redirection/ac3947cc-38ea-4651-87b9-7419b0164347',
                'created_at' => '2023-10-25 09:44:31',
            ],
            [
                'id' => 698807015,
                'id_customer' => 5,
                'resi_number' => 18022470553,
                'courier' => 'pos',
                'address' => 'gubeng raya indo no.9',
                'zipcode' => '728939',
                'status' => 1,
                'link' => 'https://app.sandbox.midtrans.com/snap/v3/redirection/2f167dfd-6ef1-4331-943c-e68534a6edea',
                'created_at' => '2023-11-01 02:50:14',
            ],
            [
                'id' => 698908708,
                'id_customer' => 6,
                'resi_number' => 18022470553,
                'courier' => 'pos',
                'address' => 'gubeng raya indo no.9',
                'zipcode' => '728939',
                'status' => 1,
                'link' => 'https://app.sandbox.midtrans.com/snap/v3/redirection/952328f3-543d-400e-b098-46ef08e68656',
                'created_at' => '2023-11-02 07:05:07',
            ],
            [
                'id' => 699777960,
                'id_customer' => 6,
                'resi_number' => 18022470553,
                'courier' => 'pos',
                'address' => 'gubeng raya indo no.9',
                'zipcode' => '728939',
                'status' => 1,
                'link' => 'https://app.sandbox.midtrans.com/snap/v3/redirection/3fbf3d31-ac26-4bdb-8cb3-eff59bf251f5',
                'created_at' => '2023-11-12 08:32:39',
            ],
            [
                'id' => 699780843,
                'id_customer' => 3,
                'resi_number' => 18022470553,
                'courier' => 'pos',
                'address' => 'gubeng raya indo no.9',
                'zipcode' => '728939',
                'status' => 1,
                'link' => 'https://app.sandbox.midtrans.com/snap/v3/redirection/9adae73d-9765-462a-8189-ada35b345e7d',
                'created_at' => '2023-11-12 09:21:22',
            ],
            [
                'id' => 693780843,
                'id_customer' => 1,
                'resi_number' => 18022470553,
                'courier' => 'pos',
                'address' => 'gubeng raya indo no.9',
                'zipcode' => '728939',
                'status' => 1,
                'link' => 'https://app.sandbox.midtrans.com/snap/v3/redirection/9adae73d-9765-462a-8189-ada35b345e7d',
                'created_at' => '2023-11-12 09:21:22',
            ],
            [
                'id' => 699780933,
                'id_customer' => 2,
                'resi_number' => 18022470553,
                'courier' => 'pos',
                'address' => 'gubeng raya indo no.9',
                'zipcode' => '728939',
                'status' => 1,
                'link' => 'https://app.sandbox.midtrans.com/snap/v3/redirection/9adae73d-9765-462a-8189-ada35b345e7d',
                'created_at' => '2023-11-12 09:21:22',
            ],
            [
                'id' => 699780883,
                'id_customer' => 4,
                'resi_number' => 18022470553,
                'courier' => 'pos',
                'address' => 'gubeng raya indo no.9',
                'zipcode' => '728939',
                'status' => 1,
                'link' => 'https://app.sandbox.midtrans.com/snap/v3/redirection/9adae73d-9765-462a-8189-ada35b345e7d',
                'created_at' => '2023-11-12 09:21:22',
            ],
        ]);
    }
}
