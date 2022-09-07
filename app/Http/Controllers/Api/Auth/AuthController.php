<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }


    public function register (Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:3',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $token = Auth::login($user);
        if ($user) {
            return response()->json([
                'status' => 'success',
                'message' => 'user has been created!',
                'user' => $user,
                // 'Authorization' => [
                //     'token' => $token,
                //     'type' => 'bearer'
                // ]
            ]);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'user not created',
            ]);
        }
    }


    public function login (Request $request)
    {
        $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string', 
    ]);

        $credentials = $request->only('email','password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        //create token if user has success login
        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout ()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'logged success'
        ]);
    }


    public function me ()
    {
        return response()->json([
            'status' => true,
            'message' => 'Data user',
            'data' => Auth::user(),
        ], 200);

    }


    public function refresh ()
    {
        return response()->json([
            'status' => 'success',
            'authorisation' => [
            'token' => Auth::refresh(),
            'type' => 'bearer',
            ]
        ]);
    }


}
