<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6']
        ]);

        $user = User::create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(Request $request){

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken('auth_token', [
                'user_id' => $user->id,
                'email' =>$user->email,
                'name' => $user->name
                ])->plainTextToken;
            return [
                'user' => $user,
                'token' => $token
            ];
        }

        return response(['message' => 'Bad Cred']);
    }


    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $response = Password::reset($request->all(), function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        return $response == Password::PASSWORD_RESET
                    ? response()->json(['message' => 'Password reset successfully'], 200)
                    : response()->json(['message' => 'Unable to reset password'], 400);
    }


}
