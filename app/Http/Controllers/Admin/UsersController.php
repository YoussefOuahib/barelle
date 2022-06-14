<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return new UserCollection($users);


    }
    public function update(Request $request, User $user)
    {
        
    }
    public function show(User $user) {
        return new UserResource($user);
    }
}
