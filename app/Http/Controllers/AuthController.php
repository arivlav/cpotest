<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request)) {
            return new ApiErrorResponse('Incorrect login or password', Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken($request->fingerprint())->plainTextToken;
        return new ApiSuccessResponse(["access_token" => $token]);
    }
}
