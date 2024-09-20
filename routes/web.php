<?php

use App\Http\Controllers\AdminButtonController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\IsUserAdmin;
use App\Http\Controllers\postController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\areYouUser;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard',[IsUserAdmin::class,'checkUserType' ])->name('dashboard');
});
Route::middleware(areYouUser::class)->group(function(){
    Route::controller(AdminButtonController::class)->group(function(){
        Route::get('logout','logMeOut')->name('logout');
        Route::get('/dashboard/friendsOnly','dashWithFriend')->name('dashboardOfOnlyFriend');
        Route::get('friendRequest','friendReq')->name('friendRequest');
        Route::get('profile/{id}','completeProfile')->name('profile');
        Route::post('searchBar','searchFriend')->name('searchBar');
        Route::post('completeProfile',[ProfileController::class,'createProfile'])->name('completeProfile');
        Route::post('postMyPost',[postController::class,'createMyPost'])->name('postMyPost');
        Route::post('/sendLike',[postController::class,'increaseLike'])->name('sendLike');
        Route::post('/sendComment',[postController::class,'increaseComment'])->name('sendComment');
        Route::post('/displayLikes',[postController::class,'displayLikes'])->name('displayLikes');
        Route::post('/displayComments',[postController::class,'displayComments'])->name('displayComments');
       
        //Route::post('sentfriendRequest',[ConnectionController::class,'friendRequest'])->name('sentfriendRequest');
        Route::controller(ConnectionController::class)->group(function(){
            Route::post('sentfriendRequest','friendRequest')->name('sentfriendRequest');
            Route::post('deleteRequest','deleteRequest')->name('deletefriendRequest');
            Route::post('acceptRequest',action: 'acceptRequest')->name('acceptfriendRequest');
            Route::get('editPost','editMyPost')->name('posts.edit');
            Route::delete('deletePost',action: 'deleteMyPost')->name('posts.destroy');
            Route::post('updateMyPost',"updatePost")->name('updateMyPost');
            
            

        });


    });
});


