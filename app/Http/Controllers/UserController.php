<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function user(Request $request)
    {
        // $user = auth()->user();
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'token_invalid'], 400);
            } else {
                return response()->json(['error' => 'token_not_found'], 401);
            }
        }
        return new UserResource($user);
    }
}
