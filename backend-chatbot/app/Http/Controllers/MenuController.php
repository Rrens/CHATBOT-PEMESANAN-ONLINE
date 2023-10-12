<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    public function index()
    {
        $active = 'menu';
        $data = Menus::paginate(10);
        return view('admin.page.menu', compact('active', 'data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'numeric'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        $data = new Menus();
        $data->name = $request->name;
        $data->price = $request->price;
        $data->stock = $request->stock;
        $data->save();

        Alert::toast('Sukses menambah menu', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'numeric'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        $data = Menus::findOrFail($request->id);
        $data->name = $request->name;
        $data->price = $request->price;
        $data->stock = $request->stock;
        $data->save();

        Alert::toast('Sukses merubah menu', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        Menus::findOrFail($request->id)->delete();
        Alert::toast('Sukses menghapus menu', 'success');
        return back();
    }
}
