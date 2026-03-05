<?php

// Magan, Kim Audrey

use App\Http\Controllers\CalculateController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home/{id}/{name}', function($id, $name){
    return '<marquee><h1>Hello World! Your id is: ' . $id . ' and your name is: ' . $name . '</h1></marquee>';
})-> name('home');

// Route::get('/about', function(){
//     return "About Page";
// });

// This may fail because if the /about changes then the route below won't get updated. 
// So we can use named routes to avoid this problem.
// Route::get('/contact', function(){
//     return '<a href="about/">Go to About Page</a>';
// });

// Parameterize your about
Route::get('aboutMe/{id}/{name}',function($id, $name){
    return '<a href="' . route('home', ['id' => $id, 'name' => $name]) . '">Go to home Page</a>';
})->name('about');

Route::get('/contact', function(){
    // The route will find the route named 'about' and generate the URL for it. 
    // So even if we change the URL for the about page, we won't have to change this link.
    // return '<a href="' . route('about') . '">Go to About Page</a>';
    return "contact page";
})->name('contact');

// Route::get('/user', function(){
//     return 'Hello you are in user';
// });

// Route::get('/user/edit/{id}', function($id){
//     return 'Hello you are in edit with id:' . $id;
// });

// Route::get('/user/add', function(){
//     return 'Hello you are in add';
// });

// Route::get('/user/delete/{id}', function($id){
//     return 'Hello you are in delete with id:' . $id;
// });

// Route Group
// Route::group(['prefix' => 'user'], function(){
//     Route::get('/', function(){
//         return 'Hello you are in user';
//     });

//     Route::get('/edit/{id}', function($id){
//         return 'Hello you are in edit with id:' . $id;
//     });

//     Route::get('/add', function(){
//         return 'Hello you are in add';
//     });

//     Route::get('/delete/{id}', function($id){
//         return 'Hello you are in delete with id:' . $id;
//     });
// });

// Route fallback
Route::fallback(function(){
    // return '404 Not Found - KIM';
    return redirect()->route('contact');
});

// Web programming: API
// just a way for applications to communicate with each other.
// API stands for Application Programming Interface. It is a set of rules and protocols that allows different software applications to communicate with each other. APIs define how requests and responses should be formatted, what endpoints are available, and how authentication should be handled. APIs are commonly used to allow third-party developers to access certain features or data of an application without giving them direct access to the underlying code or database.

// Connecting Controller to routes
// This time we do not use a function in the route, instead we will connect it to a controller method.
Route::get("/compute", [CalculateController::class, 'index'])->name('compute');

Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'user'])->name('user');

    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');

    Route::get('/add/{id}', [UserController::class, 'add'])->name('user.add');

    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
});

// Task 2
// fallback don't make it a redirect to contact but any image.