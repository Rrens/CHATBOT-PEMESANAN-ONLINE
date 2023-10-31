<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    public function index()
    {
        $active = 'order';
        $data = Orders::with('customer')->orderBy('status', 'desc')->get();
        $data_detail = OrderDetail::with('menu', 'promo')->get();

        $_URL = env('API_URL_CEK_RESI') . 'list_courier?api_key=' . env('API_KEY');
        $data_list_courier = collect(Http::get($_URL)->json());

        return view('admin.page.order', compact('active', 'data', 'data_detail', 'data_list_courier'));
    }

    public function resi_order(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'resi_number' => 'required',
            'courier' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = Orders::findOrFail($request->id);
        $data->resi_number = $request->resi_number;
        $data->courier = $request->courier;
        $data->save();

        Alert::toast('Sukses Menambah Nomor Resi', 'success');
        return back();
    }

    public function tracking($id)
    {
        $data = Orders::where('id', $id)
            ->first();

        if (empty($data)) {
            Alert::toast('Tracking tidak ada', 'error');
            return back();
        }
        $_URL = env('API_URL_CEK_RESI') . 'track?api_key=' . env('API_KEY') . '&courier=' . $data->courier . '&awb=' . $data->resi_number;
        $data_api = collect(Http::get($_URL)->json());
        return response()->json($data_api);
    }
}
