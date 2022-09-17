<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use App\Http\Resources\UserResource;

class AuthController extends ResponseController
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loginUser(Request $request) {
        $response = $this->userRepository->login($request);
        if($response["success"]) {
            return $this->sendResponse(UserResource::collection($response["data"]), 'User deleted succefully');
        }else {
            return $this->sendError('Something went wrong!', $response["errors"]);
        }
    }

    public function registerUser(Request $request) {
        $response = $this->userRepository->register($request);
        if($response["success"]) {
            return $this->sendResponse(UserResource::collection($response["data"]), 'User deleted succefully');
        }else {
            return $this->sendError('Something went wrong!', $response["errors"]);
        }
    }

    public function logoutUser(Request $request) {
        $response = $this->userRepository->logout($request);
        if($response["success"]) {
            return $this->sendResponse(UserResource::collection($response["data"]), 'User deleted succefully');
        }else {
            return $this->sendError('Something went wrong!', $response["errors"]);
        }
    }
}
