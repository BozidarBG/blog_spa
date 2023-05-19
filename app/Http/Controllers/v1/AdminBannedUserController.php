<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\v1\BanUserRequest;
use App\Http\Resources\v1\AdminBannedUsersCollection;
use App\Models\BannedUser;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminBannedUserController extends Controller
{

    public function index()
    {
        return new AdminBannedUsersCollection(
            BannedUser::with('banned_user', 'banned_by_admin')->withTrashed()->orderBy('created_at', 'desc')->paginate(20),
            200
        );
    }


    public function store(BanUserRequest $request)
    {
        $ban=new BannedUser();
        $ban->user_id=$request->user_id;
        $ban->banned_by=auth()->id();
        $ban->reason=$request->reason;
        $ban->until=Carbon::now()->addDays($request->plus_days);
        $ban->save();
        return successResponse([], 201, 'User is banned successfully');
    }


    public function destroy($id)
    {
        $banned=BannedUser::find($id);
        if($banned){
            $banned->delete();
            return successResponse([], 200, "User is un-banned successfully.");
        }else{
            return errorResponse(['ban'=>['This ban does not exist']], 404);
        }
    }


}


