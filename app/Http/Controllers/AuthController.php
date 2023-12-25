<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;

class AuthController extends BaseController
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loginUser(Request $request) {
        $response = $this->userRepository->login($request);
        if(isset($response["error"])) return $this->sendError($response['error']);

        return $this->sendSuccessAuthentification("Utilisateur connecté avec succès", $response['data']);
    }

    public function registerUser(Request $request) {
        $response = $this->userRepository->register($request);
        if(isset($response["error"])) return $this->sendError($response['error']);

        return $this->sendSuccessAuthentification("Le compte a éte créé avec succès. Un code de vérification a été envoyé a votre email", $response['data']);
    }

    public function logoutUser(Request $request) {
        $this->userRepository->logout($request);
        return $this->sendSuccess("Utilisateur déconnecté avec succès");
    }
}
