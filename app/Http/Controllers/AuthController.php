<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;

class AuthController
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loginUser(Request $request) {
        $response = $this->userRepository->login($request);
        if($response["success"]) {
            return response()->json([
                'status' => 1,
                'message' => $response['message'],
                'customer' => [
                    'id' => $response['data']['user_id'],
                    'name' => $response['data']['user_name'],
                ],
                'contacts' => [
                    'email' => $response['data']['user_email'],
                ],
                'token' => $response['data']['token'],
            ], 200);
        }
        else {
            return response()->json([
                'status' => 0,
                'message' => $response['message'],
            ]);
        }
    }

    public function registerUser(Request $request) {
        $response = $this->userRepository->register($request);
        if($response["success"]) {
            return response()->json([
                'status' => 1,
                'message' => $response['message'],
                'customer' => [
                    'id' => $response['data']['user_id'],
                    'name' => $response['data']['user_name'],
                ],
                'contacts' => [
                    'email' => $response['data']['user_email'],
                ],
                'token' => $response['data']['token'],
            ], 200);
        }
        else {
            return response()->json([
                'status' => 0,
                'message' => $response['message'],
            ]);
        }
    }

    public function logoutUser(Request $request) {
        $response = $this->userRepository->logout($request);
        return response()->json([
            'status' => 1,
            'message' => $response['message'],
        ], 200);
    }

    public function resetPasswordLink(Request $request){
        $response = $this->userRepository->sendResetPasswordLink($request);
        
    }
}
