<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\v1\ChangePasswordRequest;
use App\Http\Requests\v1\DeleteProfileRequest;
use App\Http\Requests\v1\UpdateAvatarRequest;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use File;

class ProfileController extends Controller
{

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        auth()->user()->createOrUpdateAvatar($request);

        return successResponse([], 200, 'Avatar uploaded successfully!');
    }

    public function deleteAvatar(){
        $image=auth()->user()->avatar;

        if ($image && auth()->user()->deleteAvatarFile()) {
            auth()->user()->avatar=null;
            auth()->user()->save();
            return successResponse([], 200, 'Avatar deleted');
        }else{
            return errorResponse([], 404, 'Avatar does not exist');
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {

        if($request->email === auth()->user()->email && Hash::check($request->old_password, auth()->user()->password)){
            $user=auth()->user();
        }else{
            return errorResponse(['credentials'=>['Your credentials are wrong']],422);
        }
        $user->update(['password' => Hash::make($request->new_password)]);

        return successResponse([], 200, 'Pasword updated successfully!');
    }

    public function deleteProfile(DeleteProfileRequest $request){

        if(Hash::check($request->password, auth()->user()->password)){
            $user=auth()->user();
        }else{
            return errorResponse(['password'=>['Password is incorrect']], 404);
        }

        //delete articles genres
        $articles=$user->articles()->get();
        foreach($articles as $article){
            $article->genres()->detach();
        }
        //delete articles
        Article::where('user_id', $user->id)->delete();
        //delete comments
        Comment::where('user_id', $user->id)->delete();
        //delete likes
        Like::withTrashed()->where('user_id', $user->id)->forceDelete();

        //delete token
        $user->tokens()->delete();
        //delete avatar picture if exists
        $user->deleteAvatarFile();
        //and user
        $user->delete();

        return successResponse([], 200, 'Profile deleted successfully!');
    }

}
