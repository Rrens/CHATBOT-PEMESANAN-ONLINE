<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RecomendationController extends Controller
{
    public function index()
    {
        // $sales =
        [
            'customer_id' => 10,
            'sales' => [
                [
                    "Customer_id" => 6,
                    "Promo" => "Promo_1",
                    "Product" => "Product_A"
                ],
                [
                    "Customer_id" => 6,
                    "Promo" => "Promo_1",
                    "Product" => "Product_A"
                ],
                [
                    "Customer_id" => 6,
                    "Promo" => "Promo_1",
                    "Product" => "Product_B"
                ],
                [
                    "Customer_id" => 6,
                    "Promo" => "Promo_2",
                    "Product" => "Product_C"
                ],
                [
                    "Customer_id" => 6,
                    "Promo" => "Promo_3",
                    "Product" => "Product_A"
                ],
                [
                    "Customer_id" => 7,
                    "Promo" => "Promo_1",
                    "Product" => "Product_B"
                ],
                [
                    "Customer_id" => 7,
                    "Promo" => "Promo_2",
                    "Product" => "Product_C"
                ],
                [
                    "Customer_id" => 8,
                    "Promo" => "Promo_1",
                    "Product" => "Product_A"
                ],
                [
                    "Customer_id" => 8,
                    "Promo" => "Promo_2",
                    "Product" => "Product_B"
                ]
            ]
        ];

        $data = DB::table('order_detail as od')
            ->join('orders as o', 'o.id', '=', 'od.id_order')
            ->select('o.id_customer as Customer_id', 'od.id_promo as Promo', 'od.id_menu as Product')
            ->get();
        // return response()->json($sales);
        return response()->json([
            "customer_id" => 2,
            'sales' => $data
        ]);
    }

    public function get_data()
    {
        $_URL = 'http://127.0.0.1:5000/api/sales-data';

        $data = collect(Http::get($_URL)->json());
        dd($data);
    }

    public function index2()
    {
        // $order_data = [
        //     'customer_product' => ['Product_1', 'Product_3', 'Product_5'],
        //     // 'customer_product' => null,
        //     'other_customer' => [
        //         'Customer_1' => ['Product_1', 'Product_3', 'Product_5'],
        //         'Customer_2' => ['Product_1', 'Product_2', 'Product_4', 'Product_6'],
        //         'Customer_3' => ['Product_2', 'Product_3', 'Product_4'],
        //         'Customer_4' => ['Product_5', 'Product_6', 'Product_7'],
        //         'Customer_5' => ['Product_3', 'Product_6', 'Product_8'],
        //         'Customer_6' => ['Product_2', 'Product_7', 'Product_9'],
        //         'Customer_7' => ['Product_1', 'Product_4', 'Product_8'],
        //         'Customer_8' => ['Product_3', 'Product_5'],
        //         'Customer_9' => ['Product_1', 'Product_2', 'Product_9'],
        //         'Customer_10' => ['Product_4', 'Product_7', 'Product_8'],
        //         'Customer_11' => ['Product_1', 'Product_2', 'Product_4', 'Product_5'],
        //         'Customer_12' => ['Product_3', 'Product_6', 'Product_7'],
        //         'Customer_13' => ['Product_2', 'Product_4', 'Product_5', 'Product_8'],
        //         'Customer_14' => ['Product_1', 'Product_3', 'Product_6', 'Product_9'],
        //         'Customer_15' => ['Product_1', 'Product_5', 'Product_7'],
        //         'Customer_16' => ['Product_2', 'Product_4', 'Product_8']
        //     ]
        // ];
        // return response()->json($order_data);

        $orderDetails = OrderDetail::with('menu')->get();

        $data = [];
        $customerProducts = [];

        foreach ($orderDetails as $orderDetail) {
            $customer = 'Customer_' . $orderDetail->order_id;
            $product = $orderDetail->menu[0]->name; // Ganti 'name' dengan nama kolom produk yang diinginkan

            if ($customer === 1) {
                array_push($customerProducts, $product);
            }

            if (!isset($data[$customer])) {
                $data[$customer] = [];
            }

            array_push($data[$customer], $product);
        }

        return response()->json([
            'customer_product' => $customerProducts,
            'other_customer' => $data
        ]);
    }
}
