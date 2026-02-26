<?php

// Magan, Kim Audrey
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home/{id}/{name}', function($id, $name){
    return '<marquee><h1>Hello World! Your id is: ' . $id . ' and your name is: ' . $name . '</h1></marquee>';
});

// Route::get('/about', function(){
//     return "About Page";
// });

// This may fail because if the /about changes then the route below won't get updated. 
// So we can use named routes to avoid this problem.
// Route::get('/contact', function(){
//     return '<a href="about/">Go to About Page</a>';
// });

// Parameterize your about
Route::get('aboutMe', function(){
    return "About Me Page";
})->name('about');

Route::get('/contact', function(){
    // The route will find the route named 'about' and generate the URL for it. 
    // So even if we change the URL for the about page, we won't have to change this link.
    return '<a href="' . route('about') . '">Go to About Page</a>';
});


