<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\BannedUser as Banned;
use Carbon\Carbon;

class BannedUser
{

    public function handle(Request $request, Closure $next)
    {
        $banned_user=Banned::where('user_id', auth()->id())->first();

        if($banned_user){
            if($banned_user->until > Carbon::now()){
                return errorResponse(['errors'=>['banned'=>'You are banned until '.$banned_user->until]], 403);
            }else{
                //ban has expired so we soft delete it
                $banned_user->delete();
                return $next($request);
            }
         
        }
        return $next($request);
    }
}
