<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required',
        ]);

        // $request->session()->put('phone_number', $request['phoneNumber']);
        // $request->session()->get('phone_number');
        // $request->session()->put('user.teams', 'developers');
        // session_start();
        // session()->save();
        // Log::info('Phone number stored in session USER: ' . session(['phone_number' => $request['phoneNumber']]));

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

        if ($check_phone_number->is_block == 1) {
            return response()->json([
                'meta' => [
                    'status' => 'Success',
                    'message' => 'Customer Is Blocked'
                ],
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Phone Number Founded'
            ],
            'data' => $check_phone_number,
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

    public function check_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        $data = Customers::where('whatsapp', $request['phone_number'])->first();
        // return response()->json($data);

        if (empty($data)) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => 'Customer Not Found'
                ],
            ], 200);
        }
        return response()->json([
            'meta' => [
                'status' => 'Success',
                'message' => 'Successfully Fetch Data'
            ],
            'data' => $data
        ], 200);
    }

    public function change_status(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status' => 'failed',
                    'message' => $validator->messages()->all()
                ]
            ], 400);
        }

        $data = Customers::where('whatsapp', $request['phone_number'])->first();
        if (empty($data)) {
            return response()->json([
                'meta' => [
                    'status' => 'Failed',
                    'message' => 'Customer Not Found'
                ],
            ], 200);
        }
        // return response()->json($data);
        if ($data->is_distributor == 0) {
            $data->request_distributor = 1;
            $data->save();
        }
        return response()->json([
            'meta' => [
                'status' => 'Success',
                'message' => 'Successfully Fetch Data'
            ],
            'data' => $data
        ], 200);
    }
}
