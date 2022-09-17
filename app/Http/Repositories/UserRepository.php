<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

Class UserRepository implements UserInterface {
    
    private $attributes = [
        'email' => "L'email",
        'password' => "Le mot de passe",
        'name' => "Le nom",
    ];
    private $errors = [
        'required' => ":attribute est requis.",
        'min' => ":attribute doit au moins avoir 8 caracteres.",
        'unique' => ":attribute est déja utilisé.",
        'email' => 'Veuillez saisir un email valide',
    ];

    public function login ($request)
    {
        $response = [];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], $this->errors, $this->attributes);
        if($validator->fails()){
            $response['success'] = false;
            $response['message'] = $validator->errors()->first('email')." ".$validator->errors()->first('password');
            return $response;
        }
        
        if(!Auth::attempt($request->only('email', 'password'))) {
            $response['success'] = false;
            $response['message'] = "Aucun compte n'a été trouvé avec les infomations saisies";
            return $response;
        }
        
        $user = $user = User::where('email',$request->email)->first();
        $token = $user->createToken('authToken')->plainTextToken;
        $response['success'] = true;
        $response['message'] = "Utilisateur connecté avec succès";
        $response['data'] = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'token' => $token,
        ];
        return $response;
    }

    public function register ($request)
    {
        $response = [];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|min:8|unique:users',
            'name' => 'required|string|min:8',
            'password' => 'required|string|min:8',
        ], $this->errors, $this->attributes);
        if($validator->fails()){
            $response['success'] = false;
            $response['message'] = $validator->errors()->first('email')." ".$validator->errors()->first('password')." ".$validator->errors()->first('name');
            return $response;
        }

        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        $token = $user->createToken('authToken')->plainTextToken;
        $response['success'] = true;
        $response['message'] = "Le compte a éte créé avec succès";
        $response['data'] = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'token' => $token,
        ];
        return $response;
    }

    public function logout ($request)
    {   
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $request->user()->currentAccessToken()->delete();
        $response['success'] = true;
        $response['message'] = "Utilisateur déconnecté avec succès";
        return $response;
    }

    public function sendResetPasswordLink($request)
    {
        $response = [];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], $this->errors, $this->attributes);
        if($validator->fails()){
            $response['success'] = false;
            $response['message'] = $validator->errors()->first('email');
            return $response;
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status) {
            echo(5555);
        }
        else {
            echo(2222);
        }
        
    }
}