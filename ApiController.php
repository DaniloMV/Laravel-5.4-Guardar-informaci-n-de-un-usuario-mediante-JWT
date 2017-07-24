<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use JWTAuthException;
use Tymon\JWTAuth\Providers\AbstractProvider;
use Tymon\JWTAuth\Providers\ProviderInterface;
use Validator;
use Response;
use Auth;

class RestfullControllerPasajeros extends Controller
{   
    
    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        $pasajero = User::first();

        $customClaims = ['datos' => User::first()];

        $token = null;
        try {
           if (!$token = JWTAuth::attempt($credentials, $customClaims)) {
            return response()->json(['Usuario o Contraseña incorrectos'], 422);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['Error al crear el token'], 500);
        }

        $user = JWTAuth::toUser($token);

        return response()->json(compact('token', 'user'));
    }

}  
