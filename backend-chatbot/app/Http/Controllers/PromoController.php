<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\Promos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PromoController extends Controller
{
    public function index()
    {
        $active = 'promo';
        $menus = Menus::all();
        $data = Promos::with('menu')->paginate(10);
        return view('admin.page.promo', compact('active', 'data', 'menus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu' => 'required',
            'name' => 'required',
            'discount' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        $data = new Promos();
        $data->id_menu = $request->menu;
        $data->name = $request->name;
        $data->discount = $request->discount;
        $data->save();

        Alert::toast('Sukses Menyimpan promo', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'menu' => 'required',
            'name' => 'required',
            'discount' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        $data = Promos::findOrFail($request->id);
        $data->id_menu = $request->menu;
        $data->name = $request->name;
        $data->discount = $request->discount;
        $data->save();

        Alert::toast('Sukses Merubah promo', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        Promos::findOrFail($request->id)->delete();

        Alert::toast('Sukses Menghapus promo', 'success');
        return back();
    }
}
