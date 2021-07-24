<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/', [App\Http\Controllers\PostsController::class, 'index']);

Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.show');

Route::get('/profile/{user}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->name('profile.edit');

Route::patch('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'update'])->name('profile.update');

Route::get('/posts/index', [App\Http\Controllers\PostsController::class, 'index']);

Route::get('/p/create', [App\Http\Controllers\PostsController::class, 'create']);

Route::post('/p', [App\Http\Controllers\PostsController::class, 'store']);

Route::get('/p/{post}', [App\Http\Controllers\PostsController::class, 'show']);

//follow button component route
Route::post('/follow/{user}', [App\Http\Controllers\FollowController::class, 'store']);




