<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $active = 'user';
        $data = Customers::all();
        return view('admin.page.user', compact('active', 'data'));
    }

    public function change_status_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whatsapp' => 'required',
            'is_distributor' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        if ($request->is_distributor == 1) {
            Customers::where('whatsapp', $request->whatsapp)->update([
                'is_distributor' => 0
            ]);
        } else {
            Customers::where('whatsapp', $request->whatsapp)->update([
                'is_distributor' => 1
            ]);
        }

        Alert::toast('Sukses Merubah Status User', 'success');
        return back();
    }

    public function block_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whatsapp' => 'required',
            'is_block' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        if ($request->is_block == 1) {
            Customers::where('whatsapp', $request->whatsapp)->update([
                'is_block' => 0
            ]);
        } else {
            Customers::where('whatsapp', $request->whatsapp)->update([
                'is_block' => 1
            ]);
        }

        Alert::toast('Sukses Memblokir User', 'success');
        return back();
    }
}
