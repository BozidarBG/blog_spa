<?php

namespace App\Http\Controllers\v1;

namespace App\Http\Controllers\v1;

use App\Http\Requests\v1\ForgotPasswordRequest;
use App\Http\Requests\v1\ResetPasswordRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class ForgotPasswordController extends Controller
{

    public function forgotPassword(ForgotPasswordRequest $request){

        $user=User::where('email', $request->email)->first();
        if(!$user){
            return errorResponse(['email'=>['User not found!']], 404);
        }

        Password::sendResetLink($request->all());

        return successResponse([], 200, 'Reset email sent successfully');

    }

    public function reset(ResetPasswordRequest $request)
    {

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return successResponse([], 200, 'Password retested successfully');
        }else{
            return errorResponse([], 400, 'Something went wrong. Please check your data and try again');
        }
    }

}
