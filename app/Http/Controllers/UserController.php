<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    
    public function updatePassword(Request $request){
        $response = $this->userRepository->updateUserPassword($request);
        if(isset($response['error'])) return $this->sendError($response['error']);
        
        return $this->sendSuccess("Mot de passe change avec success");
    }
}
