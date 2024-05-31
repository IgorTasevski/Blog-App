<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth.jwt')->group(function () {
    Route::prefix('posts')
        ->name('posts.')
        ->controller(PostController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{uuid}', 'showByUuid')->name('showByUuid');
            Route::post('/', 'store')->name('store');
            Route::patch('/{uuid}', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('destroy');

        });

    Route::prefix('posts/comments')
        ->name('posts.comments.')
        ->controller(CommentController::class)
        ->group(function () {
            Route::get('/{uuid}', 'index')->name('index');
            Route::get('/comment/{uuid}', 'show')->name('show');
            Route::post('/{uuid}', 'store')->name('store');
            Route::patch('/{uuid}', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('destroy');
        });

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});
