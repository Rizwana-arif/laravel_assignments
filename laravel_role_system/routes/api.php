<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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



Route::group(['middleware' => 'auth:sanctum'], function() {
    // list all posts
    Route::get('posts', [PostController::class, 'post']);
    // get a post
    Route::get('posts/{id}', [PostController::class, 'singlePost']);
    // add a new post
    Route::post('posts', [PostController::class, 'createPost']);
    // updating a post
    Route::put('posts/{id}', [PostController::class, 'updatePost']);
    // delete a post
    Route::delete('posts/{id}', [PostController::class, 'deletePost']);
    // add a new user with writer scope
    Route::post('users/writer', [PostController::class, 'createWriter']);
    // add a new user with subscriber scope
    Route::post(
        'users/subscriber',
        [PostController::class, 'createSubscriber']
    );
    // delete a user
    Route::delete('users/{id}', [PostController::class, 'deleteUser']);
});