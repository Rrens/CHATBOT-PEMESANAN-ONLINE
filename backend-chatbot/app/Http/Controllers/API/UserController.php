<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // return response()->json($request['phoneNumber']);
        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        $check_phone_number = Customers::where('whatsapp', $request['phoneNumber'])->first();
        if (empty($check_phone_number)) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Not Found'
                ],
            ], 201);
        }

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Phone Number Founded'
            ],
            'data' => $check_phone_number
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        try {
            $data = new Customers();
            $data->whatsapp = $request['phoneNumber'];
            $data->save();
            return response()->json([
                'meta' => [
                    'status' => 'Success',
                    'message' => 'Success Add Phone Number'
                ],
                'data' => $data
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Not Found'
                ],
                'data' => $error->getMessage()
            ], 201);
        }
    }
}
