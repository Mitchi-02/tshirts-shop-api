<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface UserInterface
{
    public function login (Request $request);

    public function register (Request $request);

    public function logout (Request $request);

    public function sendResetPasswordLink (Request $request);
}