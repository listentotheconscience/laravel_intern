<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::name('api.post.')->group(function () {
    Route::get('posts', [PostController::class, 'apiGetAll'])->name('all');

    Route::post('posts', [PostController::class, 'apiStore'])->name('create')
        ->middleware('auth:api');;

    Route::delete('posts', [PostController::class, 'apiDelete'])->name('delete')
        ->middleware('auth:api');;

    Route::get('post/{hash}', [PostController::class, 'apiGetByHash'])->name('hash');
});

Route::name('api.author.')->group(function () {
    Route::get('authors', [AuthorController::class, 'apiGetAll'])->name('all');

    Route::post('authors', [AuthorController::class, 'apiStore'])->name('create')
        ->middleware('auth:api');

    Route::get('authors/{id}', [AuthorController::class, 'apiGetById'])->name('id');
});

Route::name('api.user.')->middleware('auth:api')->group(function () {
    Route::get('profile', [UserController::class, 'apiProfile'])->name('profile');
});

Route::name('api.comment.')->group(function () {
    Route::post('/addComment', [CommentController::class, 'apiStore'])->name('create');

    Route::post('/deleteComment', [CommentController::class, 'apiDelete'])->name('delete');

    Route::get('/showComments', [CommentController::class, 'apiShowComments'])->name('show');
});

