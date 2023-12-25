<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            $response['error'] = join(" ", array_filter([$validator->errors()->first('email'), $validator->errors()->first('password')]));
            return $response;
        }
        
        if(!Auth::attempt($request->only('email', 'password'))) {
            $response['error'] = "Aucun compte n'a été trouvé avec les infomations saisies";
            return $response;
        }
        
        $user = $user = User::where('email',$request->email)->first();
        $token = $user->createToken('authToken')->plainTextToken;
        $response['data'] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
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
            $response['error'] = join(" ", array_filter([$validator->errors()->first('email'), $validator->errors()->first('password'), $validator->errors()->first('name')]));
            return $response;
        }

        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        $user->SendEmailVerificationCode();
        $token = $user->createToken('authToken')->plainTextToken;
        $response['message'] = "Le compte a éte créé avec succès. Un code de vérification a été envoyé a votre email";
        $response['data'] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
        ];
        return $response;
    }

    public function logout ($request)
    {   
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $request->user()->currentAccessToken()->delete();
        return ;
    }

    public function sendResetPasswordCode($request)
    {          
        $response = [];
        if(!$request->email){
            $response['error'] = "L'email est requis";
            return $response;
        }

        $user = User::firstWhere('email', $request->email);
        if(!$user){
            $response['error'] = "Aucun compte n'a été trouvé avec cette email";
            return $response;
        }

        $user->SendResetPasswordCode();
        return;
    }

    public function verifyResetPasswordCode($request)
    {
        $response = [];

        if(!$request->email || !$request->code){
            $response['error'] = "Email ou code manquant";
            return $response;
        }

        $user = User::firstWhere('email', '=', $request->email);
        if(!$user){
            $response['error'] = "Aucun compte n'a été trouvé avec cette email";
            return $response;
        }

        if($user->verification_code != $request->code) {
            $response['error'] = "Le code est invalide";
            return $response;
        }
        $user->verification_code = 100000;
        $user->save();
        return;

    }

    public function resetPassword($request)
    {   
        $response = [];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        if($validator->fails()){
            $response['error'] = "Veuillez remplir tous les champs. Le mot de passe doit etre de taille 8 minimum";
            return $response;
        }

        $user = User::firstWhere('email', '=', $request->email);
        if(!$user){
            $response['error'] = "Aucun compte n'a été trouvé avec cette email";
            return $response;
        }

        if($user->verification_code != 100000) {
            $response['error'] = "Vous n'avez pas le droit de changer le mot de passe";
            return $response;
        }
        $user->verification_code = null;
        $user->password = Hash::make($request->password);
        $user->save();
        return;
    }

    public function resendEmailVerificationCode()
    {
        $response = [];
        $user = User::find(auth('sanctum')->id());
        if($user->email_verified_at){
            $response['error'] = "Email déjà verifié";
            return $response;
        }

        $user->SendEmailVerificationCode();
        return;
    }

    public function verifyEmailVerificationCode($request)
    {
        $response = [];

        $user = User::find(auth('sanctum')->id());
        if($user->email_verified_at){
            $response['error'] = "Email déjà verifié";
            return $response;
        }

        if($user->verification_code != $request->code) {
            $response['error'] = "Le code est invalide";
            return $response;
        }

        $user->renderVerified();
        return;
    }

    public function updateUserPassword($request){
        $response = [];

        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);
        if($validator->fails()){
            $response['error'] = "Veuillez remplir les donnees. Le nouveau mot de passe doit etre de taille 8 minimum";
            return $response;
        }

        $user = User::find(auth('sanctum')->id());
        if(!Hash::check($request->password, $user->password)){
            $response['error'] = "Mot de passe incorrect";
            return $response;
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return;
    }
}