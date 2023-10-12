<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $active = 'promo';
        return view('admin.page.promo', compact('active'));
    }
}
