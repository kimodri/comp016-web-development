<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/helloworld', function (){
    return("<marquee>Hello, World!</marquee>");
});

Route::get('/hello/{name}', function ($name){
    return("Hello, " . $name . "!");
})->name("hello-name");

Route::group(["prefix" => "login"], function(){
    Route::get('/', [LoginController::class, 'getLogin'])->name('login');
    Route::post('/post-login', [LoginController::class, 'postLogin'])->name('login.submit');
});