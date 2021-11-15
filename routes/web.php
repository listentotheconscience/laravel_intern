<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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
Route::get('/', function () {
    return view('home')->with('title', 'Home Page');
});

/*
 * Auth routes
 */

Route::name('auth.')->group(function () {
    Route::get('/login', function () {
        return view('login')->with('title', 'Log In');
    })->name('login.view');

    Route::get('/signin', function () {
        return view('signin')->with('title', 'Sign In');
    })->name('signin.view');

    Route::post('/signin', [AuthController::class, 'register'])->name('signin');

    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
 * Post routes
 */

Route::name('post.')->group(function () {
    Route::get('/posts', [PostController::class, 'getAll'])->name('all');

    Route::get('/create_post', [PostController::class, 'createPost'])->name('create.view');

    Route::post('/create_post', [PostController::class, 'store'])->name('create');

    Route::get('/post/{hash}', [PostController::class, 'getByHash'])->where(['hash' => '[a-zA-Z0-9]+'])
        ->name('hash');

    Route::get('/deletePost/{id}', [PostController::class, 'deletePost'])->name('delete');
});

/*
 * Authors routes
 */

Route::name('author.')->middleware('verified')->group(function () {
    Route::get('/authors', [AuthorController::class, 'getAll'])->name('all');

    Route::get('/create_author', function () {
        return view('create_author', ['title' => 'Create Author']);
    })->name('create.view');

    Route::post('/create_author', [AuthorController::class, 'store'])->name('create');

    Route::get('/author/{id}', [AuthorController::class, 'getById'])->name('profile');
});

/*
 * User routes
 */

Route::name('user.')->middleware('verified')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.view');
});

/*
 * Comment routes
 */

Route::name('comment.')->middleware('verified')->group(function () {
    Route::post('/addComment', [CommentController::class, 'store'])->name('create');

    Route::get('/deleteComment', [CommentController::class, 'delete'])->name('delete');
});


/*
 * Verification routes
 */

Route::get('/email/verify', function () {
    return view('verifyemail')->with('title', 'Email Verification');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verification'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');
