<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendSuccess($message, $data = [], $support = "")
    {
        $response = [
            'status' => 1,
            'message' => $message,
        ];

        if(!empty($data)) {
            $response['data'] = $data;
        }
        if(!empty($support)) {
            $response['support'] = $support;
        }
        return response()->json($response, 200);
    }

    public function sendSuccessAuthentification($message, $user)
    {
        $response = [
            'status' => 1,
            'message' => $message,
            'customer' => [
                'id' => $user['id'],
                'name' => $user['name'],
            ],
            'contacts' => [
                'email' => $user['email'],
            ],
            'token' => $user['token'],
        ];
        return response()->json($response, 200);
    }

    public function sendError($error)
    {
        $response = [
            'status' => 0,
            'message' => $error
        ];

        return response()->json($response);
    }

}
