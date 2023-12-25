<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface UserInterface
{
    public function login (Request $request);

    public function register (Request $request);

    public function logout (Request $request);

    public function sendResetPasswordCode (Request $request);

    public function verifyResetPasswordCode(Request $request);

    public function resetPassword(Request $request);

    public function resendEmailVerificationCode ();

    public function verifyEmailVerificationCode(Request $request);

    public function updateUserPassword(Request $request);

}