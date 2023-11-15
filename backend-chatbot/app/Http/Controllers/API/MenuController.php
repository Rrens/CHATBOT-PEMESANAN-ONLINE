<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Menus;
use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\Recomendation_detail;
use App\Models\Recomendations;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index($phone_number)
    {

        $data = Menus::all();
        $recomendation = Recomendations::whereHas('customer', function ($query) use ($phone_number) {
            $query->where('whatsapp', $phone_number);
        })
            ->latest()
            ->first();
        $recomendation_detail = Recomendation_detail::where('id_recomendation', $recomendation->id)->get();
        $array_recomendation_menu = array();

        foreach ($recomendation_detail as $item) {
            // dd($item);
            // dd(Menus::where('id', $item['id_menu'])->first()['name']);
            array_push($array_recomendation_menu, Menus::where('id', $item['id_menu'])->first()['name']);
        }
        // dd($array_recomendation_menu);
        if (!empty($data[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Successfully fetch data'
                ],
                'data' => $data,
                'recomendation' => $array_recomendation_menu
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'failed',
                'message' => 'Data not found'
            ]
        ], 404);
    }

    public function sales()
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


        // IKI KRISSS
        $id_customer = 6;

        $orderDetails = OrderDetail::with('menu', 'order')
            ->whereHas('order', function ($query) use ($id_customer) {
                $query->where('status', 1);
            })
            ->get();

        $count_orders = Orders::where('status', 1)
            ->groupBy('id_customer')
            ->get();

        $data = [];
        $customerProducts = [];
        $customerCounts = [];
        $array_order = array();

        $loop_order = 1;
        foreach ($count_orders as $item) {
            array_push($array_order, $loop_order++);
        }
        foreach ($orderDetails as $item) {
            $customer = $item->order[0]->id_customer;
            $product = $item->menu[0]->id;

            if ($item->order[0]->id_customer == $id_customer) {
                array_push($customerProducts, $item->id_menu);
            }

            if (!isset($customerCounts[$customer])) {
                $customerCounts[$customer] = 1;
            }

            $customer = 'Customer_' . $customer;

            if (!isset($data[$customer])) {
                $data[$customer] = [];
            }

            array_push($data[$customer], $product);
        }
        ksort($data);

        return response()->json([
            // 'id_customer' => 'Customer_' . 1,
            'id' => $id_customer,
            'customer_product' => $customerProducts,
            // 'customer_product' => [
            //     1,
            //     2
            // ],
            'other_customer' => $data
        ]);
    }
}
