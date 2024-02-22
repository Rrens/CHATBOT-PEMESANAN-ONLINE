<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function index()
    {
        $active = 'admin';
        $data = User::all();
        return view('admin.page.admin', compact('data', 'active'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:6',
            'role' => 'required|in:superadmin,admin_order,admin_konten'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        unset($request['_token']);
        $data = new User();
        $data->fill($request->all());
        $data->password = Hash::make($request->password);
        $data->save();

        Alert::toast('Sukses Menyimpan', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|exists:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:superadmin,admin_order,admin_konten',
        ]);

        if ($validator->fails()) {
            dd($validator->messages()->all());
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $data = User::where('email', $request->email)->first();
        $data->fill($request->all());
        $data->password = Hash::make($request->password);
        $data->save();

        Alert::toast('Sukses Merubah', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        User::where('id', $request->id)->delete();

        Alert::toast('Sukses Menghapus', 'success');
        return back();
    }
}
