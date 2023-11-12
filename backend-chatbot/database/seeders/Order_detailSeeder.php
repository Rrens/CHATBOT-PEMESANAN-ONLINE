<?php

namespace Database\Seeders;

use App\Models\Menus;
use App\Models\Promos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Order_detailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_detail')->insert([
            [
                'id_order' => 698223680,
                'id_menu' => 11,
                'id_promo' => null,
                'promo_amount' => null,
                'price' => $this->get_menu_price(11),
                'quantity' => 4,
            ],
            [
                'id_order' => 698223680,
                'id_menu' => 6,
                'id_promo' => 6,
                'promo_amount' => $this->get_promo_amount(6, 6),
                'price' => $this->get_promo_amount(6, 6),
                'quantity' => 4,
            ],
            [
                'id_order' => 698227072,
                'id_menu' => 6,
                'id_promo' => 6,
                'promo_amount' => $this->get_promo_amount(6, 6),
                'price' => $this->get_promo_amount(6, 6),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 698227072,
                'id_menu' => 6,
                'id_promo' => 6,
                'promo_amount' => $this->get_promo_amount(6, 6),
                'price' => $this->get_promo_amount(6, 6),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 698227072,
                'id_menu' => 3,
                'id_promo' => 3,
                'promo_amount' => $this->get_promo_amount(3, 3),
                'price' => $this->get_promo_amount(3, 3),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 698227072,
                'id_menu' => 4,
                'id_promo' => 4,
                'promo_amount' => $this->get_promo_amount(4, 4),
                'price' => $this->get_promo_amount(4, 4),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 698227072,
                'id_menu' => 5,
                'id_promo' => 5,
                'promo_amount' => $this->get_promo_amount(5, 5),
                'price' => $this->get_promo_amount(5, 5),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 698227072,
                'id_menu' => 6,
                'id_promo' => 6,
                'promo_amount' => $this->get_promo_amount(6, 6),
                'price' => $this->get_promo_amount(6, 6),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 698227072,
                'id_menu' => 8,
                'id_promo' => 8,
                'promo_amount' => $this->get_promo_amount(8, 8),
                'price' => $this->get_promo_amount(8, 8),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 698227072,
                'id_menu' => 10,
                'id_promo' => 10,
                'promo_amount' => $this->get_promo_amount(8, 8),
                'price' => $this->get_promo_amount(8, 8),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 698807015,
                'id_menu' => 6,
                'id_promo' => 6,
                'promo_amount' => $this->get_promo_amount(6, 6),
                'price' => $this->get_promo_amount(6, 6),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 698908708,
                'id_menu' => 11,
                'id_promo' => null,
                'promo_amount' => null,
                'price' => $this->get_menu_price(2),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 698908708,
                'id_menu' => 6,
                'id_promo' => 6,
                'promo_amount' => $this->get_promo_amount(6, 6),
                'price' => $this->get_promo_amount(6, 6),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 699777960,
                'id_menu' => 6,
                'id_promo' => 6,
                'promo_amount' => $this->get_promo_amount(6, 6),
                'price' => $this->get_promo_amount(6, 6),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 699780883,
                'id_menu' => 6,
                'id_promo' => 6,
                'promo_amount' => $this->get_promo_amount(6, 6),
                'price' => $this->get_promo_amount(6, 6),
                'quantity' => rand(1, 4),
            ],
            [
                'id_order' => 699780883,
                'id_menu' => 11,
                'id_promo' => null,
                'promo_amount' => null,
                'price' => $this->get_menu_price(11),
                'quantity' => rand(1, 4),
            ],
        ]);
    }

    public function get_promo_amount($menu, $promo)
    {
        $promo_discount = Promos::where('id', $promo)->first()['discount'];
        $menu_price = Menus::where('id', $menu)->first()['price'];
        $result =  $menu_price - ($menu_price * ($promo_discount / 100));
        return $result;
    }

    public function get_menu_price($menu)
    {
        $menu_price = Menus::where('id', $menu)->first()['price'];
        return $menu_price;
    }
}
