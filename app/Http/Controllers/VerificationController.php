<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use Illuminate\Http\Request;

class VerificationController extends BaseController
{   
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendPasswordCode(Request $request)
    {
        $response = $this->userRepository->sendResetPasswordCode($request);
        if(isset($response['error'])) return $this->sendError($response['error']);
        
        return $this->sendSuccess("Code envoye");
    }

    public function verifyPasswordCode(Request $request)
    {
        $response = $this->userRepository->verifyResetPasswordCode($request);
        if(isset($response['error'])) return $this->sendError($response['error']);
        
        return $this->sendSuccess("Vérification réussi");
    }

    public function resetUserPassword(Request $request)
    {
        $response = $this->userRepository->resetPassword($request);
        if(isset($response['error'])) return $this->sendError($response['error']);
        
        return $this->sendSuccess("Mot de passe changé avec succès");
    }

    public function resendEmailVerification()
    {
        $response = $this->userRepository->resendEmailVerificationCode();
        if(isset($response['error'])) return $this->sendError($response['error']);
        
        return $this->sendSuccess("Code envoye");
    }

    public function verifyEmailVerifCode(Request $request)
    {
        $response = $this->userRepository->verifyEmailVerificationCode($request);
        if(isset($response['error'])) return $this->sendError($response['error']);
        
        return $this->sendSuccess("Vérification email réussi");
    }
}
