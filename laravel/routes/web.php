<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
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
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/add/{id}', [UserController::class, 'add'])->name('user.add');
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
});

Route::fallback(function(){
    return '<img src="' . asset('src/explosion-boom.gif') . '" alt="404 Not Found" style="width: 100%; height: 100%; object-fit: cover;">';
});

