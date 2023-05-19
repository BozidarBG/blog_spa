<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function login(LoginRequest $request)
    {
        $request->authenticate();


        $token = $request->user()->createToken('authtoken');

        return successResponse(
            [
            //'user'=> $request->user(),
            'token'=> $token->plainTextToken
        ],200, 'You are logged in');
    }

    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();

        return successResponse([], 200, 'User logged out');

    }
}
