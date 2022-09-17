<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function sendSucces($result, $message)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $result,
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessage=[])
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }
        return response()->json($response);
    }
}
