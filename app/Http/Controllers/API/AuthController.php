<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('Token')->accessToken;
        return response()->json(['token'=>$token,'user'=>$user],200); 
    } 
    public function login(Request $request){
            $data =[
                'email'=>$request->email,
                'password'=>$request->password
                ];
            if(auth()->attempt($data)){
                //$token = auth()->user()->createToken('Token')->accessToken;
                $token = $request->user()->createToken($request->token_name);
                return response()->json(['token'=>$token],200);              
            }
            else{
                return response()->json(['error'=>'Unauthorized'],401); 
            }               
    }

    public function userInfo(){
        $user = auth()->user();
        return response()->json(['user'=>$user],200);         
    }
}
