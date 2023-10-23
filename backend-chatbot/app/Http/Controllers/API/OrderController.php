<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Menus;
use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\Promos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        $order = Orders::where('id_customer', Customers::where('whatsapp', $request['customer'])->first()['id'])
            ->where('status', 0)
            ->first();

        if (!empty($order)) {
            $data = OrderDetail::with('menu', 'promo')
                ->where('id_order', $order->id)
                ->get();

            return response()->json([
                'meta' => [
                    'status' => 'Success',
                    'message' => 'Order Successfully'
                ],
                'data' => [
                    'order' => $data,
                ]
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'Success',
                'message' => 'Order Not Found'
            ],
        ], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
            'quantity' => 'required|integer',
            'customer' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        $menu = Menus::where('name', $request['product'])->first();

        $check_stock = Menus::where('id', $menu->id)->where('stock', '>=', $request['quantity'])->first();


        // CHECK PRODUCT
        if (empty(Menus::where('name', $request['product'])->first())) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => 'Product Not Available'
                ],
            ], 200);
        }

        if (empty($check_stock)) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => 'Stock Not Available'
                ],
            ], 200);
        }



        $customer_id = Customers::where('whatsapp', $request['customer'])->first()['id'];

        $checkAvailableProductOnOrder = OrderDetail::with('order')
            ->whereHas('order',  function ($query) use ($customer_id) {
                $query->where('status', 0)
                    ->where('id_customer', $customer_id);
            })
            ->where('id_menu', $menu->id)->first();

        $data = Orders::where('id_customer', $customer_id)->where('status', 0)->first();

        $checkQuantity = OrderDetail::where('id_menu', $menu->id)->where('id_order', $data->id)->first()['quantity']
            +
            $request['quantity'];
        if ($checkQuantity > Menus::where('id', $menu->id)->first()['stock']) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => 'Out of Stock'
                ],
            ], 200);
        }

        if (empty($checkAvailableProductOnOrder)) {

            if (empty($data)) {
                $data = new Orders();
                $data->id_customer = Customers::where('whatsapp', $request['customer'])->first()['id'];
                $data->save();
            }

            $promo = Promos::where('id_menu', $menu->id)->first();

            $data_detail = new OrderDetail();
            $data_detail->id_order = $data->id;
            $data_detail->id_menu = $menu->id;
            $data_detail->quantity = (int) $request['quantity'];
            if (!empty($promo)) {
                $data_detail->id_promo = $promo->id;
                $data_detail->promo_amount = (int) $menu->price * ($promo->discount / 100);
                $data_detail->price = (int) $data_detail->promo_amount * $data_detail->quantity;
            } else {
                $data_detail->price = (int) $menu->price * $data_detail->quantity;
            }
            $data_detail->save();
        } else {
            $data_detail = OrderDetail::where('id_order', $data->id)
                ->where('id_menu', $menu->id)
                ->first();
            // $data_detail->id_menu = $menu->id;
            $data_detail->quantity += (int) $request['quantity'];
            if (!empty($promo)) {
                $data_detail->id_promo = $promo->id;
                $data_detail->promo_amount = (int) $menu->price * ($promo->discount / 100);
                $data_detail->price = (int) $data_detail->promo_amount * $data_detail->quantity;
            } else {
                $data_detail->price = (int) $menu->price * $data_detail->quantity;
            }

            $data_detail->save();
        }

        $data_chatbot = OrderDetail::with('menu', 'promo')
            ->where('id_order', $data->id)
            ->get();

        return response()->json([
            'meta' => [
                'status' => 'Success',
                'message' => 'Order Successfully'
            ],
            'data' => [
                'order' => $data_chatbot,
            ]
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
            'quantity' => 'required|integer',
            'customer' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        $customer_id = Customers::where('whatsapp', $request['customer'])->first()['id'];

        if (empty(OrderDetail::with('order')->whereHas('order', function ($query) use ($customer_id) {
            $query->where('id_customer', $customer_id)->where('status', 0);
        })->first())) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => 'Order Not Found'
                ],
            ], 200);
        }

        $check_stock = Menus::where('name', $request['product'])->where('stock', '>=', $request['quantity'])->first();

        // CHECK PRODUCT
        if (empty(Menus::where('name', $request['product'])->first())) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => 'Product Not Available'
                ],
            ], 200);
        }

        if (empty($check_stock)) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => 'Stock Not Available'
                ],
            ], 200);
        }

        $data = Orders::where('id_customer', $customer_id)->where('status', 0)->first();
        $menu = Menus::where('name', $request['product'])->first();
        $promo = Promos::where('id_menu', $menu->id)->first();

        $checkAvailableProductOnOrder = OrderDetail::with('order')
            ->whereHas('order',  function ($query) use ($customer_id) {
                $query->where('status', 0)
                    ->where('id_customer', $customer_id);
            })
            ->where('id_menu', $menu->id)->first();

        $checkQuantity = OrderDetail::where('id_menu', $menu->id)->where('id_order', $data->id)->first()['quantity']
            +
            $request['quantity'];
        if ($checkQuantity > Menus::where('id', $menu->id)->first()['stock']) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => 'Out of Stock'
                ],
            ], 200);
        }

        if (!empty($checkAvailableProductOnOrder)) {

            $data_detail = OrderDetail::where('id_order', $data->id)
                ->where('id_menu', $menu->id)
                ->first();
            $data_detail->quantity = (int) $request['quantity'];
            if (!empty($promo)) {
                $data_detail->id_promo = $promo->id;
                $data_detail->promo_amount = (int) $menu->price * ($promo->discount / 100);
                $data_detail->price = (int) $data_detail->promo_amount * $data_detail->quantity;
            } else {
                $data_detail->price = (int) $menu->price * $data_detail->quantity;
            }
            $data_detail->save();

            $data_chatbot = OrderDetail::with('menu', 'promo')
                ->where('id_order', $data->id)
                ->get();

            return response()->json([
                'meta' => [
                    'status' => 'Success',
                    'message' => 'Update Successfully'
                ],
                'data' => [
                    'order' => $data_chatbot,
                ]
            ], 200);
        } else {
            return $this->store($request);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
            'product' => 'required',
        ]);



        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        try {
            $customer = Customers::where('whatsapp', $request['customer'])->first()['id'];

            $cek = OrderDetail::where(
                'id_order',
                Orders::where('id_customer', $customer)
                    ->where('status', 0)
                    ->first()['id']
            )
                ->where(
                    'id_menu',
                    Menus::where('name', $request['product'])
                        ->first()['id']
                )
                ->first();

            if (!empty($cek)) {
                $cek->delete();
                return response()->json([
                    'meta' => [
                        'status' => 'Success',
                        'message' => 'Delete Order Successfully'
                    ],
                ], 200);
            }
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => 'Data Not Found'
                ],
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => $error->getMessage()
                ],
            ], 400);
        }
    }
}
