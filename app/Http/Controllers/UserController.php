<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected function guard()
    {
        return Auth::guard();
    }
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember_me = true;

        if (Auth::attempt($credentials, $remember_me)) {
            $user = User::where('email', $request->email)->first();

            $token = $user->createToken('auth_token')->plainTextToken;

            $request->session()->regenerate();
            if ($user->isAdmin()) {
                $admin = true;
            } else {
                $admin = false;
            }
            return response()->json(['message' => 'Login Successful', 'logged' => true, 'isAdmin' => true, 'name' => $user->name], 200);
        } else {
            return response()->json(['message' => 'Invalid Credentials']);
        }
    }
    public function register(StoreUserRequest $request)
    {

        $user = User::Create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->sendEmailVerificationNotification();
        $this->guard()->login($user);
        return response()->json(['message' => 'Account created successfully', 'logged' => true, 'token' => $token], 200);
    }

    public function profile()
    {
        return new UserResource(auth()->user());
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        Session::flush();
        return response()->json(['message' => 'Logged Out'], 200);
    }
}
