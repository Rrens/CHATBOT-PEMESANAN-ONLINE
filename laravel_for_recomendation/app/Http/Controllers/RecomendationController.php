<?php

namespace App\Http\Controllers;

use App\Models\Recomendation_detail;
use App\Models\Recomendations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecomendationController extends Controller
{
    public function index()
    {
        $_URL = 'http://127.0.0.1:5100/api/sales';
        $data = collect(Http::get($_URL)->json());
        // dd($data['data']['recommended_products']);

        $recomendation = new Recomendations();

        $recomendation->id_customer = $data['data']['id_customer'];
        $recomendation->save();

        foreach ($data['data']['recommended_products'] as $item) {
            $recomendation_detail = new Recomendation_detail();
            $recomendation_detail->id_recomendation = $recomendation->id;
            $recomendation_detail->id_menu = $item;
            $recomendation_detail->save();
        }

        return response()->json([
            'recomendation' => $recomendation,
            'recomendation_detail' => $recomendation_detail
        ]);
    }
}
