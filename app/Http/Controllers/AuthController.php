<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $user = User::where("email", "=", $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($request->fingerprint())->plainTextToken;
            return new ApiSuccessResponse(["access_token" => $token]);
        } else {
            return new ApiErrorResponse('Incorrect login or password', Response::HTTP_NOT_FOUND);
        }
    }
}
