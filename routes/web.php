<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;


Auth::routes();

Route::get('/login', function () {
    return view('auth.auth'); })->name('login');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/register', function () {
    return redirect('/login'); });

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notification.read');


    Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
        Route::get('/user/{id}', [PostController::class, 'userPost'])->name('user');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/show', [PostController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [PostController::class, 'destroy'])->name('destroy');
    });
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function () {
        Route::post('/{post_id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
    });
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::patch('/update', [UserController::class, 'update'])->name('update');
    });
});
