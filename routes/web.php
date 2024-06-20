<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\XpostsController;
use App\Http\Controllers\UserFollowController;
use App\Http\Controllers\UserFavoriteController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [XpostsController::class, 'index']);

Route::get('/dashboard', [XpostsController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'users/{id}'], function () {                                         
        Route::post('follow', [UserFollowController::class, 'store'])->name('user.follow');       
        Route::delete('unfollow', [UserFollowController::class, 'destroy'])->name('user.unfollow'); 
        Route::get('followings', [UsersController::class, 'followings'])->name('users.followings'); 
        Route::get('followers', [UsersController::class, 'followers'])->name('users.followers'); 
        Route::get('favorites',[UsersController::class, 'favorites'])->name('favorites');
    });  

    Route::resource('users', UsersController::class, ['only' => ['index', 'show']]);
    Route::resource('xposts', XpostsController::class, ['only' => ['store', 'destroy']]);

    Route::group(['prefix' => 'xpost/{id}'], function () {                                             
        Route::post('favorite', [UserFavoriteController::class, 'store'])->name('userfavorite.store');       
        Route::delete('unfavorite', [UserFavoriteController::class, 'destroy'])->name('userfavorite.destroy'); 
        
    });
});
