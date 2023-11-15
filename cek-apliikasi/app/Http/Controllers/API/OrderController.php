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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Midtrans\Config;
use Midtrans\Snap;

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
                    'message' => 'Order Fetch Successfully'
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

        if (empty($menu)) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => 'Product Not Available'
                ],
            ], 200);
        }

        $check_stock = Menus::where('id', $menu->id)->where('stock', '>=', $request['quantity'])->first();

        // CHECK PRODUCT
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



        if (empty($checkAvailableProductOnOrder)) {

            if (empty($data)) {
                $uniqid = floor(time() - 999999999);
                $data = new Orders();
                $data->id = $uniqid;
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

            $data_detail = OrderDetail::where('id_order', $data->id)
                ->where('id_menu', $menu->id)
                ->first();
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

    public function checK_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        try {
            $data = [
                'credit card',
                'bca',
                'permata',
                'bni',
                'bri',
                'mandiri',
                'danamon',
                'other bank',
                'gopay qris',
                'shopeepay qris',
                'other qris',
                'indomaret',
                'alfamart',
                'kredivo',
                'akulaku',
            ];

            return response()->json([
                'meta' => [
                    'status' => 'Success',
                    'message' => 'Success Fetch Data'
                ],
                'data' => $data
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

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
            'address' => 'required|regex:([\d\sa-zA-Z,.]+)',
            'zip_code' => 'required|regex:(\d+)'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        // return response()->json($request->all());
        $customer = Customers::where('whatsapp', $request['customer'])->first();
        $order = Orders::with('customer')->where('id_customer', $customer->id)->where('status', 0)->first();

        if (empty($order)) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => 'Order Not Found'
                ],
            ], 404);
        } else {

            $order->address = $request['address'];
            $order->zipcode = $request['zip_code'];

            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = config('services.midtrans.isDSanitized');
            Config::$is3ds = config('services.midtrans,is3ds');

            $midtrans = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => (int) OrderDetail::where('id_order', $order->id)->sum('price'),
                ],
                'customer_details' => [
                    'phone' => $order->customer[0]->whatsapp,
                ],
                'enabled_payments' => [
                    'gopay',
                    'bank_transfer',
                    'credit_card',
                    'bca_va',
                    'permata_va',
                    'bni_va',
                    'bri_va',
                    'echannel',
                    'cimb_va',
                    'other_va',
                    'gopay',
                    'shopeepay',
                    'other_qris',
                    'bca_klikbca',
                    'bca_klikpay',
                    'cimb_clicks',
                    'bri_epay',
                    'danamon_online',
                    'uob_ezpay',
                    'indomaret',
                    'alfamart',
                    'kredivo',
                    'akulaku',
                ],
                'vtweb' => []
            ];

            try {
                $payment_url = Snap::createTransaction($midtrans)->redirect_url;
                $order->link = $payment_url;
                $order->status = 1;
                // HAPUS KETIKA SUDAH DI HOSTING
                $order_detail = OrderDetail::where('id_order', $order->id)->get();
                foreach ($order_detail as $item) {
                    $menu = Menus::findOrFail($item->id_menu);
                    $menu->stock -= $item->quantity;
                    $menu->save();
                }
                $order->save();

                return response()->json([
                    'meta' => [
                        'status' => 'success',
                        'message' => 'Success Checkout'
                    ],
                    'data' => $order
                ], 200);
            } catch (Exception $error) {
                return response()->json([
                    'meta' => [
                        'status' => 'error',
                        'message' => 'Something went wrong'
                    ],
                    'data' => $error->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'meta' => [
                'status' => 'Success',
                'message' => 'Delete Order Successfully'
            ], 'data' => $order
        ], 200);
    }

    public function list_order_per_date(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
            'date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        $date = $request['date'];

        $data_order = Orders::whereRaw("DATE_FORMAT(created_at, '%d-%m-%Y') = ?", date('d-m-Y', strtotime($date)))
            ->where('status', 1)
            ->where('payment_status', null)
            ->get();

        $data_detail = OrderDetail::with('menu', 'promo')->get();

        if (!empty($data_order[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'Success',
                    'message' => 'Order Fetch Successfully'
                ],
                'data' => [
                    'data_order' => $data_order,
                    'data_detail' => $data_detail
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

    public function check_order_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $data_order = Orders::where('id_customer', Customers::where('whatsapp', $request['customer'])->first()['id'])
            ->where('status', 1)
            ->where('payment_status', null)
            ->get();

        $data_detail = OrderDetail::with('menu', 'promo')->get();


        if (empty($data_order[0])) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => 'Data not found'
                ],
            ], 404);
        }

        return response()->json([
            'meta' => [
                'status' => 'Success',
                'message' => 'Successfully fetch data'
            ], 'data' => [
                'data_order' => $data_order,
                'data_detail' => $data_detail
            ]
        ], 200);
    }

    public function tracking_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
            'resiNumber' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        $data = Orders::where('id_customer', Customers::where('whatsapp', $request['customer'])->first()['id'])
            ->where('resi_number', $request['resiNumber'])
            ->where('status', 1)
            ->first();
        // return response()->json($data);

        if (empty($data)) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => 'Data not found'
                ],
            ], 404);
        }

        try {
            $_URL = env('API_URL_CEK_RESI') . 'track?api_key=' . env('API_KEY') . '&courier=' . $data->courier . '&awb=' . $data->resi_number;
            // return response()->json($_URL);
            $data_from_api = collect(Http::get($_URL)->json());
            if (!empty($data_from_api)) {
                $data = $data_from_api;
            } else {
                $data = null;
            }

            return response()->json([
                'meta' => [
                    'status' => 'Success',
                    'message' => 'Successfully fetch data'
                ], 'data' => $data
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => $error->getMessage()
                ],
            ], 500);
        }
    }
}
