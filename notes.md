# COMP016 Web Development — Laravel Routing Notes

**Author:** Magan, Kim Audrey

---

## Table of Contents

1. [Basic Routing](#basic-routing)
2. [Route Parameters](#route-parameters)
3. [Named Routes](#named-routes)
4. [Route Groups](#route-groups)
5. [Route Fallback](#route-fallback)
6. [Controllers](#controllers)
7. [APIs (Application Programming Interface)](#apis-application-programming-interface)

---

## Basic Routing

Routes define how your application responds to HTTP requests. In Laravel, routes are defined in `routes/web.php`.

The simplest route accepts a URI and a closure (anonymous function):

```php
Route::get('/', function () {
    return view('welcome');
});
```

You can return plain strings, HTML, or views:

```php
Route::get('/about', function () {
    return "About Page";
});
```

---

## Route Parameters

You can capture segments of the URL as parameters by wrapping them in curly braces `{}`. These are passed as arguments to your route's closure or controller method.

### Single Parameter

```php
Route::get('/user/edit/{id}', function ($id) {
    return 'Hello you are in edit with id:' . $id;
});
```

### Multiple Parameters

You can define multiple parameters in a single route:

```php
Route::get('/home/{id}/{name}', function ($id, $name) {
    return 'Hello World! Your id is: ' . $id . ' and your name is: ' . $name;
})->name('home');
```

When generating URLs for routes with multiple parameters, pass them as an associative array:

```php
route('home', ['id' => $id, 'name' => $name])
```

---

## Named Routes

Named routes allow you to generate URLs or redirects using a route's **name** instead of hardcoding the URL path. This is important because if the URL path changes, all links using the named route will automatically update.

### The Problem (Hardcoded URLs)

```php
Route::get('/about', function () {
    return "About Page";
});

// This link will BREAK if /about changes to /about-us
Route::get('/contact', function () {
    return '<a href="about/">Go to About Page</a>';
});
```

### The Solution (Named Routes)

Assign a name to a route using `->name()`, then generate URLs using the `route()` helper:

```php
Route::get('/about', function () {
    return "About Page";
})->name('about');

Route::get('/contact', function () {
    // route('about') generates the correct URL automatically
    return '<a href="' . route('about') . '">Go to About Page</a>';
})->name('contact');
```

Now even if `/about` changes to `/about-us`, the link on the contact page will still work correctly.

### Named Routes with Parameters

```php
Route::get('aboutMe/{id}/{name}', function ($id, $name) {
    return '<a href="' . route('home', ['id' => $id, 'name' => $name]) . '">Go to home Page</a>';
})->name('about');
```

---

## Route Groups

When you have multiple routes that share a common prefix, you can group them together using `Route::group()` to avoid repetition.

### Without Grouping (Repetitive)

```php
Route::get('/user', function () {
    return 'Hello you are in user';
});

Route::get('/user/edit/{id}', function ($id) {
    return 'Hello you are in edit with id:' . $id;
});

Route::get('/user/add', function () {
    return 'Hello you are in add';
});

Route::get('/user/delete/{id}', function ($id) {
    return 'Hello you are in delete with id:' . $id;
});
```

### With Grouping (Clean & Organized)

```php
Route::group(['prefix' => 'user'], function () {
    Route::get('/', function () {
        return 'Hello you are in user';
    });

    Route::get('/edit/{id}', function ($id) {
        return 'Hello you are in edit with id:' . $id;
    });

    Route::get('/add', function () {
        return 'Hello you are in add';
    });

    Route::get('/delete/{id}', function ($id) {
        return 'Hello you are in delete with id:' . $id;
    });
});
```

All routes inside the group will automatically be prefixed with `/user`, so `/edit/{id}` becomes `/user/edit/{id}`.

---

## Route Fallback

The fallback route catches **any request that doesn't match a defined route**. It acts as a custom 404 page. It should always be the last route defined.

```php
Route::fallback(function () {
    return '<img src="' . asset('src/explosion-boom.gif') . '" alt="404 Not Found">';
});
```

> **Note:** Use the `asset()` helper to generate correct URLs for files in the `public/` directory. Avoid relative paths like `../public/src/...` as they won't resolve correctly.

---

## Controllers

Instead of defining all route logic in closures, you can organize it into **Controller classes**. Controllers group related request handling logic into a single class.

### Connecting a Route to a Controller

```php
use App\Http\Controllers\CalculateController;

Route::get("/compute", [CalculateController::class, 'index'])->name('compute');
```

This tells Laravel: when someone visits `/compute`, call the `index` method on `CalculateController`.

### Example Controller (`CalculateController`)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculateController extends Controller
{
    public function index()
    {
        return "<h1>Result: " . (2 + 3) . "</h1>";
    }
}
```

### Route Groups with Controllers

You can combine route groups with controllers for clean organization:

```php
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'user'])->name('user');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/add/{id}', [UserController::class, 'add'])->name('user.add');
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
});
```

### Example Controller (`UserController`)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user()
    {
        return "Hello you are in user";
    }

    public function add($id)
    {
        return "Hello you are in add with id:" . $id;
    }

    public function edit($id)
    {
        return "Hello you are in edit with id:" . $id;
    }

    public function delete($id)
    {
        return "Hello you are in delete with id:" . $id;
    }
}
```

---

## APIs (Application Programming Interface)

**API** stands for **Application Programming Interface**. It is a set of rules and protocols that allows different software applications to communicate with each other.

APIs define:
- How **requests** and **responses** should be formatted
- What **endpoints** are available
- How **authentication** should be handled

APIs are commonly used to allow third-party developers to access certain features or data of an application without giving them direct access to the underlying code or database.

In web development, APIs typically use HTTP methods (`GET`, `POST`, `PUT`, `DELETE`) and exchange data in formats like **JSON**.
