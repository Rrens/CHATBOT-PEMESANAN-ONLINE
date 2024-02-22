<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OmzetController extends Controller
{
    public function index()
    {
        $active = 'omzet';
        $data = DB::table('order_detail as od')
            ->join('orders as o', 'o.id', '=', 'od.id_order')
            ->selectRaw('* ,SUM(od.price) as omzet')
            ->groupBy('o.id')
            ->orderBy('o.created_at', 'ASC')
            ->get();

        $year_select = $this->year();

        $data_detail = OrderDetail::all();
        return view('admin.page.omzet', compact('active', 'data', 'data_detail', 'year_select'));
    }

    public function filter($year)
    {
        $active = 'omzet';
        $data = DB::table('order_detail as od')
            ->join('orders as o', 'o.id', '=', 'od.id_order')
            ->selectRaw('* ,SUM(od.price) as omzet')
            ->groupBy('o.id')
            ->orderBy('o.created_at', 'ASC')
            ->whereYear('o.created_at', $year)
            ->get();

        $year_select = $this->year();

        $data_detail = OrderDetail::all();
        return view('admin.page.omzet', compact('active', 'data', 'data_detail', 'year_select', 'year'));
    }

    public function year()
    {
        return DB::table('orders')
            ->selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->get();
    }
}
