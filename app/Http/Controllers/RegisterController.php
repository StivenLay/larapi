<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    //
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $credentials = $request->only('email', 'password');
        $token = auth()->attempt($credentials);

        return (new UserResource($request->user()))
            ->additional(['meta' => [
                'token' => $token,
            ]]);
    }
}
