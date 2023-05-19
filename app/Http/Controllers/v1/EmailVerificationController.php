<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ResendConfirmationEmailRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class EmailVerificationController extends Controller
{
    public function verifyEmail($id, $hash){
        $user=User::find($id);
        if(!$user){
            //return response()->json(['errors'=>true, 'data'=>'User not found!']);
            return errorResponse([], 404, 'User not found!');
        }
        if(!hash_equals($hash, sha1($user->getEmailForVerification()))){
            //return response()->json(['errors'=>true, 'data'=>'Something is wrong with the link you provided!']);
            return errorResponse([], 404, 'Something is wrong with the link you provided!');
        }

        if(!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        //return response()->json(['success'=>true, 'data'=>'Account is verified']);
        return successResponse([], 200, 'Account is verified');
    }

    public function resendConfirmEmailAddress(ResendConfirmationEmailRequest $request){
        $user=User::where('email', $request->email)->first();
        if(!$user){
            return errorResponse(['email'=>['User not found!']], 404);
        }
        if($user->email_verified_at){
            return errorResponse(['email'=>['User is already verified']], 400);
        }
        $user->sendEmailVerificationNotification();
        return successResponse([], 200, 'Email resent. Please, check your inbox!');
    }
}
