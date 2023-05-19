<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Laravel\Sanctum\HasApiTokens;
use File;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable /*,ImageUploader*/;


    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $avatars_folder="storage".DIRECTORY_SEPARATOR."avatars".DIRECTORY_SEPARATOR;

    public static $defaults_folder="images/defaults/";

    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function isAdmin(){
        return $this->role===1;
    }
    public function banned(){
        return $this->hasMany(BannedUser::class, 'user_id')->withTrashed();
    }

    public function sendPasswordResetNotification($token)
    {
        //frontend client
        $url = env('FRONTEND_URL').'/reset-password?token=' . $token;
        //dd($url);//http://spablog.test/reset-password?token=c041343209350a93bb6c07244ed38d419d2f1ff13ebbf2f59be4386507ef0642
        $this->notify(new ResetPasswordNotification($url));
    }

    public function createOrUpdateAvatar($request){
        $image = $request->file('avatar');
        // Rename image

        $file_name = time(). str_replace(' ', '_', auth()->user()->name). '.' .$image->guessExtension();

        $image->move($this->avatars_folder, $file_name);

        $old_image = isset(auth()->user()->avatar) ? auth()->user()->avatar : null;

        if ($old_image) {
           $this->deleteAvatar();
        }

        auth()->user()->avatar = $file_name;
        auth()->user()->save();
    }

    public function deleteAvatarFile(){
        $path = parse_url($this->avatars_folder.auth()->user()->avatar);
        return $path ? File::delete(public_path($path['path'])) : false;
    }
}
