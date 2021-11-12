<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credential = $request->only('email', 'password');
        if (!$token = auth()->attempt($credential)) {
            return response()->json(['error', 'ivalid_credntial'], 401);
        }

        return (new UserResource($request->user()))
            ->additional(['meta' => [
                'token' => $token,
            ]]);
    }
}
