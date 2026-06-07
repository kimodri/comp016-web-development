<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home/{id}/{name}', [HomeController::class, 'home'])->name('home');

Route::get('aboutMe/{id}/{name}', [AboutController::class, 'about'])->name('about')->name('about');

Route::get('/contact', [ContactController::class, 'contact'])->name('contact');

Route::get("/compute", [CalculateController::class, 'index'])->name('compute');

Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'user'])->name('user');
    Route::post('/', [UserController::class, 'userSubmit'])->name('user.submit');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/add/{id}', [UserController::class, 'add'])->name('user.add');
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
});


// Calculator
Route::get('compute/{num1}/{num2}', [CalculateController::class, 'compute'])->name('compute');

// Login
Route::get('/login', [LoginController::class, 'login'])->name('login');

// Post
Route::get('/post', [PostController::class, 'index'])->name('post.form');
Route::post('/post', [PostController::class, 'store'])->name('post');
Route::get('/post/update/{id}', [PostController::class, 'showUpdate'])->name('post.showUpdate');
Route::put('/post/update/{id}', [PostController::class, 'updateSubmit'])->name('post.updateSubmit');
// Route::put('/post/update', [PostController::class, 'updateSubmit'])->name('post.updateSubmit');

Route::fallback(function(){
    return '<img src="' . asset('src/explosion-boom.gif') . '" alt="404 Not Found" style="width: 100%; height: 100%; object-fit: cover;">';
});