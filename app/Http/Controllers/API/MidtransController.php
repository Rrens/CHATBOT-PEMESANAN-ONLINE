<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menus;
use App\Models\OrderDetail;
use App\Models\Orders;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isDSanitized');
        Config::$is3ds = config('services.midtrans,is3ds');

        $notification = new Notification();

        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        $transaction = Orders::findOrFail($order_id);



        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->payment_status = 'PENDING';
                } else {
                    $transaction->payment_status = 'SUCCESS';
                }
            }
        } else if ($status == 'settlement') {
            $transaction->payment_status = 'SUCCESS';
            $transaction->save();
            $order_detail = OrderDetail::where('id_order', $order_id)->get();
            foreach ($order_detail as $item) {
                $menu = Menus::findOrFail($item->id_menu);
                $menu->quantity -= $item->quantity;
                $menu->save();
            }
        } else if ($status == 'pending') {
            $transaction->payment_status = 'PENDING';
        } else if ($status == 'deny') {
            $transaction->payment_status = 'CANCELLED';
        } else if ($status == 'expire') {
            $transaction->payment_status = 'CANCELLED';
        } else if ($status == 'cancel') {
            $transaction->payment_status = 'CANCELLED';
        }

        // Save Transaction
        $transaction->save();
    }
}
