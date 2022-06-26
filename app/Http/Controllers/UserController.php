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

        $user = User::where('email', $request->email)->first();
        $remember_me = true;
        if ($user->isAdmin()) {
            $admin = true;
        } else {
            $admin = false;
        }
        if (Auth::attempt($credentials, $remember_me)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            $request->session()->regenerate();
            return response()->json(['message' => 'Login Successful', 'logged' => true, 'isAdmin' => $admin, 'name' => $user->name], 200);
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
