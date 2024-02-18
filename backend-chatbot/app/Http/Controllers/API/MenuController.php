<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Menus;
use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\Recomendation_detail;
use App\Models\Recomendations;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{

    public function sales($phone_number)
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

        // if (session()->has('phone_number')) {
        //     $phoneNumber = session('phone_number');
        // } else {
        //     return response()->json('gaada');
        // }
        // $phone_number = session('phone_number');
        // Log::info('Phone number from session MENU: ' . $phone_number);
        // return $phone_number;

        // dd($phone_number);
        $id_customer = Customers::where('whatsapp', $phone_number)->first()['id'];
        // IKI KRISSS

        $orderDetails = OrderDetail::with('menu', 'order')
            ->whereHas('order', function ($query) use ($id_customer) {
                $query->where('status', 1);
            })
            // ->groupBy('id_menu')
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
        // return response()->json($customerProducts);
        ksort($data);

        $data_for_post = [
            // 'id_customer' => 'Customer_' . 1,
            'id' => $id_customer,
            'customer_product' => array_values(array_unique($customerProducts)),
            // 'customer_product' => [
            //     1,
            //     2
            // ],
            'other_customer' => $data
        ];

        // return response()->json($data_for_post);

        try {
            $response = Http::post(env('API_RECOMENDATION'), [
                $data_for_post
            ]);

            return response()->json($response->json());
        } catch (Exception $error) {
            //     dd($error->getMessage());
            return response()->json($error);
        }

        // return response()->json([
        //     // 'id_customer' => 'Customer_' . 1,
        //     'id' => $id_customer,
        //     'customer_product' => $customerProducts,
        //     // 'customer_product' => [
        //     //     1,
        //     //     2
        //     // ],
        //     'other_customer' => $data
        // ]);
    }

    public function index($phone_number)
    {
        $this->sales($phone_number);
        // return response()->json($this->sales($phone_number));
        $data = Menus::all();
        $order_detail = DB::table('order_detail as od')
            ->join('orders as o', 'o.id', '=', 'od.id_order')
            ->join('customers as c', 'c.id', '=', 'o.id_customer')
            ->select('od.id_menu')
            ->groupBy('od.id_menu')
            ->where('c.whatsapp', $phone_number)
            ->get();

        $data_menu_customer = array_column(json_decode($order_detail, true), 'id_menu');

        $recomendation = Recomendations::whereHas('customer', function ($query) use ($phone_number) {
            $query->where('whatsapp', $phone_number);
        })
            ->latest()
            ->first();
        if (!empty($recomendation)) {

            $recomendation_detail = Recomendation_detail::where('id_recomendation', $recomendation->id)
                ->whereNotIn('id_menu', $data_menu_customer)
                ->get();
        } else {
            $recomendation = Recomendations::whereHas('customer', function ($query) use ($phone_number) {
            })
                ->latest()
                ->first();
        }

        $recomendation_detail = Recomendation_detail::where('id_recomendation', $recomendation->id)
            ->whereNotIn('id_menu', $data_menu_customer)
            ->get();

        $array_recomendation_menu = array();

        if (!empty($recomendation_detail[0])) {
            foreach ($recomendation_detail as $item) {
                // dd($item);
                // dd(Menus::where('id', $item['id_menu'])->first()['name']);
                array_push($array_recomendation_menu, Menus::where('id', $item['id_menu'])->first()['name']);
            }
        } else {
            // return response()->json($data_menu_customer);
            array_push($array_recomendation_menu, Menus::whereNotIn('id', $data_menu_customer)->pluck('name'));
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
}
