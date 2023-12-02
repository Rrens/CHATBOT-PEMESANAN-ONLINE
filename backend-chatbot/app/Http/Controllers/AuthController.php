<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login()
    {
        if (!Auth::check()) {
            return view('admin.auth.login');
        }

        return redirect()->route('user.index');
    }

    public function post_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all());
            return back()->withInput();
        }

        $data = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (!Auth::attempt($data)) {
            Alert::toast('Username atau Password Salah', 'error');
            return redirect()->route('login')->withInput();
        }

        return redirect()->route('user.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
