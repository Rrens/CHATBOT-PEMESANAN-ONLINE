<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Orders;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RecomendationController extends Controller
{
    // public function index()
    // {
    //     // $sales =
    //     [
    //         'customer_id' => 10,
    //         'sales' => [
    //             [
    //                 "Customer_id" => 6,
    //                 "Promo" => "Promo_1",
    //                 "Product" => "Product_A"
    //             ],
    //             [
    //                 "Customer_id" => 6,
    //                 "Promo" => "Promo_1",
    //                 "Product" => "Product_A"
    //             ],
    //             [
    //                 "Customer_id" => 6,
    //                 "Promo" => "Promo_1",
    //                 "Product" => "Product_B"
    //             ],
    //             [
    //                 "Customer_id" => 6,
    //                 "Promo" => "Promo_2",
    //                 "Product" => "Product_C"
    //             ],
    //             [
    //                 "Customer_id" => 6,
    //                 "Promo" => "Promo_3",
    //                 "Product" => "Product_A"
    //             ],
    //             [
    //                 "Customer_id" => 7,
    //                 "Promo" => "Promo_1",
    //                 "Product" => "Product_B"
    //             ],
    //             [
    //                 "Customer_id" => 7,
    //                 "Promo" => "Promo_2",
    //                 "Product" => "Product_C"
    //             ],
    //             [
    //                 "Customer_id" => 8,
    //                 "Promo" => "Promo_1",
    //                 "Product" => "Product_A"
    //             ],
    //             [
    //                 "Customer_id" => 8,
    //                 "Promo" => "Promo_2",
    //                 "Product" => "Product_B"
    //             ]
    //         ]
    //     ];

    //     $data = DB::table('order_detail as od')
    //         ->join('orders as o', 'o.id', '=', 'od.id_order')
    //         ->select('o.id_customer as Customer_id', 'od.id_promo as Promo', 'od.id_menu as Product')
    //         ->get();
    //     // return response()->json($sales);
    //     return response()->json([
    //         "customer_id" => 2,
    //         'sales' => $data
    //     ]);
    // }



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

        $orderDetails = OrderDetail::with('menu', 'order')
            ->whereHas('order', function ($query) {
                $query->where('status', 1);
            })
            ->get();

        $count_orders = Orders::where('status', 1)
            ->groupBy('id_customer')
            ->get();

        $data = [];
        $customerProducts = [];
        $customerCounts = [];
        // $cek = array();
        $array_order = array();

        $loop_order = 1;
        foreach ($count_orders as $item) {
            array_push($array_order, $loop_order++);
        }
        // dd($array_order);

        // $loop = 0;
        foreach ($orderDetails as $item) {
            $customer = $item->order[0]->id_customer;
            $product = $item->menu[0]->id;

            // !empty($customer) ? $loop++ : $loop;

            // array_push($cek, $loop);

            if ($item->order[0]->id_customer == 5) {
                array_push($customerProducts, $item->id_menu);
            }

            // dd($orderDetails->where('id_order', $item->id_order)->count());

            // if ($customer === 5) {
            //     array_push($customerProducts, $product);
            // }
            // dd($loop);
            // Ubah awalan "Customer_" menjadi nilai yang berawal dari 1
            if (!isset($customerCounts[$customer])) {
                $customerCounts[$customer] = 1;
            }

            // $customerKey = 'Customer_' . $customerCounts[$customer];
            // if ($customerCounts[$customer] != $customer) {
            //     $customerCounts[$customer]++;
            // }

            $customer = 'Customer_' . $customer;
            // $customer = $customerKey;
            // $customer = $customer;

            if (!isset($data[$customer])) {
                $data[$customer] = [];
            }

            array_push($data[$customer], $product);
            // $loop++;
        }
        ksort($data);
        // dd($cek);


        return response()->json([
            'id_customer' => 'Customer_' . 1,
            // 'customer_product' => $customerProducts,
            'customer_product' => [
                1,
                // 6,
                // 6,
                // 6,
                // 3,
                // 4,
                // 5,
                // 6,
                // 8,
                // 10,
                // 6
            ],
            'other_customer' => $data
        ]);
    }

    // public function get_data()
    // {
    //     try {
    //         //code...
    //         $_URL = 'http://127.0.0.1:5100/api/sales';
    //         $data = collect(Http::get($_URL)->json());
    //         return response()->json($data);
    //     } catch (Exception $error) {
    //         //throw $th;
    //         dd($error);
    //     }
    // }
}
