<?php

use App\Http\Controllers\v1\EmailVerificationController;
use App\Http\Controllers\v1\LoginController;
use App\Http\Controllers\v1\ForgotPasswordController;
use App\Http\Controllers\v1\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\AdminArticleController;
use App\Http\Controllers\v1\AdminBannedUserController;
use App\Http\Controllers\v1\AdminCommentController;
use App\Http\Controllers\v1\AdminGenreController;
use App\Http\Controllers\v1\AdminUserController;
use App\Http\Controllers\v1\ArticleController;
use App\Http\Controllers\v1\CommentController;
use App\Http\Controllers\v1\GenreController;
use App\Http\Controllers\v1\LikeController;
use App\Http\Controllers\v1\ProfileController;



//routes for all
//must not have api/v1 prefix. without Bearer token
Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verifyEmail'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');


Route::prefix('v1')->group(function(){
    Route::post('/resend-verification-email', [EmailVerificationController::class, 'resendConfirmEmailAddress'])->middleware(['throttle:6,1'])->name('verification.send');
    Route::post('/send-forgot-password-email', [ForgotPasswordController::class, 'forgotPassword'])->middleware(['throttle:60,1'])->name('password.email');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->middleware(['throttle:6,1'])->name('password.update');

    Route::post('/register', [RegisterController::class, 'register'])->middleware(['guest']);
    Route::post('/login', [LoginController::class, 'login'])->middleware(['guest','throttle:3,1'])->name('login');

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/genres', [GenreController::class, 'index']);
    Route::get('/genres/{id}', [GenreController::class, 'show']);
});


//registered, verified and authenticated users that are not banned, with Bearer token
Route::prefix('v1')->middleware(['auth:sanctum', 'not_banned', 'verified'])->group(function(){
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{id}', [ArticleController::class, 'update']);
    Route::delete('/delete-articles/{id}', [ArticleController::class, 'destroy']);

    Route::post('/toggle-like/{id}', [LikeController::class, 'toggle']);

    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

    Route::post('/update-avatar', [ProfileController::class, 'updateAvatar']);
    Route::put('/change-password', [ProfileController::class, 'changePassword']);
    Route::delete('/delete-avatar', [ProfileController::class, 'deleteAvatar']);
    Route::delete('/delete-profile', [ProfileController::class, 'deleteProfile']);//nisam

});

//admin routes
Route::prefix('v1/admin')->middleware(['auth:sanctum', 'admin'])->group(function(){
    Route::delete('/delete-article/{id}', [AdminArticleController::class, 'destroy']);
    Route::delete('/delete-comment/{id}', [AdminCommentController::class, 'destroy']);
    Route::post('/genres', [AdminGenreController::class, 'store']);
    Route::put('/genres/update/{id}', [AdminGenreController::class, 'update']);
    Route::delete('/delete-genre/{id}', [AdminGenreController::class, 'destroy']);

    Route::get('/banned-users', [AdminBannedUserController::class, 'index']);
    Route::post('/banned-users/', [AdminBannedUserController::class, 'store']);
    Route::delete('/banned-users/destroy/{id}', [AdminBannedUserController::class, 'destroy']);

    Route::get('/users', [AdminUserController::class, 'index']);
});

Route::fallback(function() {
    return errorResponse(['errors'=>['This request is unsupported']], 400);
});
