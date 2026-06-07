# Laravel / PHP / MVC — A Progression Guide (built from YOUR project)

> This guide teaches Laravel in the **exact order you built this project**. Every code
> snippet below is taken from your own `laravel/` app, then annotated. Read top to bottom —
> each lesson assumes the one before it. The companion file `02-PRACTICE-TEST.md` quizzes you
> on the same code.

---

## Lesson 0 — Orientation & Setup Cheat-Sheet

### What are these words?
- **PHP** — the server-side programming language. It runs on the server, builds an HTML
  page, and sends that HTML to the browser. The browser never sees your PHP.
- **Laravel** — a *framework* (a big pre-written toolbox) written in PHP. It gives you
  routing, database tools, templating, validation, etc. so you don't reinvent them.
- **MVC** — **M**odel–**V**iew–**C**ontroller, the way Laravel organizes code:
  - **Model** = data / database layer (in your project you mostly used the **Query Builder**
    `DB::table(...)` instead of full Models — that's fine, more on this in Lesson 10).
  - **View** = what the user sees — your `.blade.php` files.
  - **Controller** = the "brain" that receives the request, talks to the data, and picks a View.
- **Blade** — Laravel's templating language for views. Files end in `.blade.php` and let you
  mix HTML with directives like `@foreach`, `@if`, and `{{ $variable }}`.

### The request lifecycle (memorize this diagram)

```
Browser  ──request──►  routes/web.php  ──►  Controller method  ──►  View (.blade.php)
 (URL)                  (matches URL)        (gets data, logic)      (HTML sent back)
```

Everything in this guide is just filling in pieces of that line.

### Commands to start / run a Laravel project

```bash
# Create a brand-new project (only once, at the start)
composer create-project laravel/laravel myapp

# Move into it
cd myapp

# Generate the app encryption key (needed before the app runs)
php artisan key:generate

# Front-end assets (Bootstrap/Sass/JS via Vite) — your project uses this
npm install
npm run dev          # keep this running in a 2nd terminal while developing

# Run the local PHP web server
php artisan serve    # serves at http://127.0.0.1:8000
```

`composer` = PHP's package manager (installs Laravel + PHP libraries).
`npm` = JavaScript's package manager (installs front-end stuff).
`php artisan ...` = Laravel's command-line tool. You'll use it constantly.

### Artisan generators you used / will use

```bash
php artisan make:controller PostController     # creates app/Http/Controllers/PostController.php
php artisan make:migration create_post_table   # creates a DB migration file
php artisan migrate                             # runs migrations (builds the tables)
php artisan route:list                          # shows every route (great for debugging)
```

### The `.env` file
Holds your environment settings — most importantly the database. In your project:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webdev-magan
DB_USERNAME=root
DB_PASSWORD=kim123
```

### THE BUILD ORDER (your mental checklist for any feature)
When the exam (or real life) asks you to add a feature, build it in this order:

```
1. ROUTE        → add a line in routes/web.php pointing a URL to a controller method
2. CONTROLLER   → write the method (handle input, do logic)
3. VIEW         → make the .blade.php the controller returns
4. VALIDATION   → if there's a form, validate the input
5. DATABASE     → if data must persist, insert/update with DB::table()
```

Keep this list in your head. Almost every exam question is "fill in one of these 5 steps."

---

## Lesson 1 — Routing Basics

A **route** maps a URL to some code. The simplest route returns a value directly.

From your `routes/web.php`:

```php
Route::get('/', function () {
    return view('welcome');
});
```

- `Route::get(...)` → respond to a **GET** request (a normal page visit).
- `'/'` → the URL (here, the homepage).
- The closure (anonymous function) runs and `return view('welcome')` shows
  `resources/views/welcome.blade.php`.

A route can also return plain text/HTML through a controller. From your `ContactController`:

```php
public function contact(){
    Log::info('Showing contact page.');
    return "You are in contact page";   // returns a raw string, not a view
}
```

> **Rule to memorize:** `Route::get('url', handler)`. A handler can be a closure or a
> controller method. Whatever you `return` is the response — a string, HTML, or a `view()`.

---

## Lesson 2 — Route Parameters

You can capture parts of the URL using `{curly braces}` and receive them as method arguments.

Route (from `routes/web.php`):

```php
Route::get('/home/{id}/{name}', [HomeController::class, 'home'])->name('home');
```

Controller (`HomeController`):

```php
public function home($id, $name){
    Log::info('Showing home page.');
    return '<marquee><h1>Hello World! Your id is: ' . $id . ' and your name is: ' . $name . '</h1></marquee>';
}
```

Visiting `/home/5/Kim` → `$id = 5`, `$name = "Kim"`.

> **The order matters:** the **order** of `{id}/{name}` in the URL maps to the **order** of
> the method arguments `($id, $name)` — the names just need to line up positionally.

### Generating URLs back — the `route()` helper
Instead of hard-coding `/home/5/Kim`, build the URL from the route's **name**. From `AboutController`:

```php
return '<a href="' . route('home', ['id' => $id, 'name' => $name]) . '">Go to home Page</a>';
```

`route('home', [...])` looks up the route named `home` and fills in its parameters.

> **Rule:** Never hard-code URLs. Name your routes and use `route('name', [params])`.

---

## Lesson 3 — Controllers

When logic grows past one line, move it out of the route and into a **controller**.

Create one:

```bash
php artisan make:controller PostController
```

Anatomy of a controller (your `LoginController`):

```php
<?php

namespace App\Http\Controllers;     // tells Laravel where this class lives

use Illuminate\Http\Request;        // import the Request class so methods can receive input

class LoginController extends Controller   // extends the base Controller
{
    public function login(){
        return view('login');        // returns resources/views/login.blade.php
    }
}
```

Wire it to a route:

```php
Route::get('/login', [LoginController::class, 'login'])->name('login');
//                    [  WhichController::class , 'whichMethod' ]
```

To receive form/request data, type-hint `Request $request` (you'll use this in Lesson 9):

```php
public function userSubmit(Request $request){ ... }
```

> **Rule:** `[ControllerClass::class, 'methodName']` connects a route to a controller method.
> Always include `namespace App\Http\Controllers;` and `extends Controller`.

---

## Lesson 4 — Named Routes, Route Groups & Fallback

### Naming routes
Add `->name('...')` so you can refer to a route by a stable name:

```php
Route::post('/', [UserController::class, 'userSubmit'])->name('user.submit');
```

Now `route('user.submit')` always produces the right URL, even if you change `/` later.

### Grouping routes (shared prefix)
From your `routes/web.php` — every URL inside shares the `user` prefix:

```php
Route::group(['prefix' => 'user'], function(){
    Route::get('/',            [UserController::class, 'user'])->name('user');           // GET  /user
    Route::post('/',           [UserController::class, 'userSubmit'])->name('user.submit'); // POST /user
    Route::get('/edit/{id}',   [UserController::class, 'edit'])->name('user.edit');      // GET  /user/edit/5
    Route::get('/add/{id}',    [UserController::class, 'add'])->name('user.add');        // GET  /user/add/5
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');  // GET  /user/delete/5
});
```

### Fallback (catch-all 404)
Runs when **no** route matches:

```php
Route::fallback(function(){
    return '<img src="' . asset('src/explosion-boom.gif') . '" ...>';
});
```

> **Rule:** `['prefix' => 'user']` prepends `user/` to every URL in the group. `Route::fallback`
> is your 404 handler.

---

## Lesson 5 — Views & Blade Basics

A **view** is an HTML page with PHP sprinkled in via Blade. It lives in `resources/views/`
and the controller returns it by name (no `.blade.php`, no folder slashes if at root):

```php
return view('login');   // -> resources/views/login.blade.php
```

Subfolders use dot notation: `view('common.main')` → `resources/views/common/main.blade.php`.

**Echoing data** uses double curly braces. From `calculate.blade.php`:

```blade
<p>Sum: {{ $sum }}</p>
```

> `{{ $sum }}` prints `$sum` **and auto-escapes HTML** (protects against injection). That
> escaping is why you almost always use `{{ }}` instead of raw PHP `echo`.

---

## Lesson 6 — Layouts & Partials (don't repeat your HTML)

Rather than copy `<html><head>...` into every page, define one **layout** with "holes",
then have each page fill the holes.

Your layout `resources/views/common/main.blade.php`:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield("title")</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/login.css'])
</head>
<body>
    @include('common.header')        {{-- pulls in header.blade.php --}}
    <div class="my-3 container">
        @yield('content')            {{-- the page-specific content drops in here --}}
    </div>
    @include('common.footer')        {{-- pulls in footer.blade.php --}}
</body>
</html>
```

A child page that fills those holes — your `calculate.blade.php`:

```blade
@extends("common.main")              {{-- "I use this layout" --}}
@section("title", "calculate")       {{-- fills @yield("title") — short form --}}
@section("content")                  {{-- fills @yield('content') — block form --}}

<h1 style="color: blue;">Calculate Page</h1>
<p>Sum: {{ $sum }}</p>

@endsection
```

| Directive | Job |
|-----------|-----|
| `@extends('layout')` | "I am built on top of this layout" |
| `@yield('name')` | (in the layout) a hole to be filled |
| `@section('name', 'value')` | fill a hole with a short value |
| `@section('name') ... @endsection` | fill a hole with a block of HTML |
| `@include('partial')` | paste another blade file here (header/footer) |
| `@vite([...])` | load compiled CSS/JS assets |

> **Rule:** Layout has `@yield`. Child has `@extends` + `@section`. Reusable chunks come in
> with `@include`.

---

## Lesson 7 — Passing Data from Controller to View

The controller computes data and hands it to the view. The standard way is `compact()`,
which bundles variables into an array keyed by their name.

Your `CalculateController@compute` (trimmed):

```php
$sum        = $this->add($num1, $num2);
$difference = $this->difference($num1, $num2);
$product    = $util->product($num1, $num2);
// ... $quotient is also computed up here ...

return view('calculate', compact('sum', 'difference', 'product'));
//                        ^ same as ['sum' => $sum, 'difference' => $difference, 'product' => $product]
```

In `calculate.blade.php` those become available as `$sum`, `$difference`, `$product`:

```blade
<p>Sum: {{ $sum }}</p>
<p class="diff">Difference: {{ $difference }}</p>
<p>Product: {{ $product }}</p>
<p>Results: {{ $sum . $difference . $product }}</p>   {{-- . is string concatenation --}}
```

> **Variable scope — exam trap:** The view can ONLY see variables you actually passed.
> In your code `$quotient` is computed in the controller but is **NOT** in `compact('sum',
> 'difference', 'product')`. So writing `{{ $quotient }}` in the view would throw an
> "Undefined variable" error. **If it's not compacted, the view can't see it.**

---

## Lesson 8 — Logging & Error Handling

### Logging (`Log` facade)
Used throughout your controllers to record what's happening (output goes to
`storage/logs/laravel.log`):

```php
use Illuminate\Support\Facades\Log;

Log::info('Showing home page.');        // normal info
Log::debug('Yah Yah');                  // detailed debug (often turned off in production)
Log::error('ERROR: ' . $e->getMessage()); // something went wrong
```

### try / catch / finally
Wrap risky code so an error doesn't crash the whole page. Your `CalculateController@compute`:

```php
try{
    $quotient = $util->quotient($num1, $num2);
    Log::info('quotient = ' . $quotient);
}catch(Throwable $e){                    // catch ANY error/exception
    Log::error('Error: ' . $e->getMessage());
}finally{                                // runs whether it succeeded or failed
    Log::info('Any Message!');
}
```

- `try { }` — code that might fail.
- `catch(Exception $e) { }` — handles normal exceptions.
- `catch(Throwable $e) { }` — `Throwable` is broader; catches Exceptions **and** Errors.
- `finally { }` — always runs (cleanup, final logging).

### Method visibility & controller-to-controller calls
From your calculator code:

```php
private function add($p1, $p2){ ... }     // private = only callable inside THIS class via $this->
public  function difference($p1, $p2){ ... } // public = callable from outside

$sum  = $this->add($num1, $num2);          // calling a method on the same controller
$util = new UtilController();              // making an instance of another controller
$product = $util->product($num1, $num2);   // calling its public method
```

> **Rule:** `private` methods are internal helpers (`$this->add(...)`). `public` methods can
> be called from other classes. `Throwable` catches more than `Exception`.

---

## Lesson 9 — Forms, CSRF & Validation (the core skill)

This is where most exam points live. Follow the **field-name chain**:

```
<input name="fname">   →   $request->fname   →   validate 'fname'   →   insert 'fname'
```

### The form — your `userInfo.blade.php`

```blade
<form class="customForm" method="POST" action="{{ route('user.submit') }}">
    @csrf                                        {{-- REQUIRED on every POST form --}}

    @if($errors->any())                          {{-- show validation errors --}}
        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <input type="text"     name="fname">
    <input type="text"     name="mname">
    <input type="text"     name="lname">
    <input type="email"    name="email">
    <input type="password" name="password">
    <input type="submit" value="Submit" class="btn btn-warning">
</form>
```

- `method="POST"` + `action="{{ route('user.submit') }}"` → posts to the named route.
- **`@csrf`** outputs a hidden security token. **Without it, Laravel rejects the POST with a
  419 error.** Memorize: every POST/PUT/DELETE form needs `@csrf`.
- `$errors` is automatically available in every view — loop it to display messages.

### The controller — your `UserController@userSubmit`

```php
public function userSubmit(Request $request){
    $request->validate([
        'fname' => ['required', 'max:16'],
        'lname' => ['required', 'min:2'],
        'email' => ['required', 'email', 'ends_with:@microsoft.com'],
    ], [
        'fname.required' => 'Hello first name required!',  // custom message: field.rule
        'lname.min'      => "Bawal isa lang :)",
    ]);

    DB::table('users')->insert([
        'fname'    => $request->fname,
        'mname'    => $request->mname,
        'lname'    => $request->lname,
        'email'    => $request->email,
        'password' => Hash::make($request->password),   // NEVER store raw passwords
    ]);

    $users = DB::table('users')->get();
    return $users;   // (your code returns the raw list; normally you'd redirect — see Lesson 11)
}
```

- `$request->validate([...])` — keys are field names, values are arrays of rules. **If
  validation fails, Laravel automatically redirects back with `$errors`** (your method body
  below never even runs).
- Second argument = **custom messages**, keyed as `'field.rule'`.
- `Hash::make(...)` one-way-hashes the password.

### `old()` — keep what the user typed
On a failed submit, repopulate fields so users don't retype everything. From `post.blade.php`:

```blade
<input type="text" name="title" value="{{ old('title') }}">
```

> **Rules to burn in:**
> - Every POST/PUT/DELETE form → `@csrf`.
> - `name=` in HTML must match the key in `validate()` and `$request->`.
> - Custom messages are keyed `'field.rule'`.
> - `Hash::make()` for passwords; `{{ old('field') }}` to repopulate.

---

## Lesson 10 — Database with the Query Builder

Your project talks to the database with the **Query Builder** (`DB::table(...)`) rather than
Eloquent Models. The Query Builder writes SQL for you through chainable methods.

```php
use Illuminate\Support\Facades\DB;

// INSERT (CREATE)
DB::table('post')->insert([
    'title'      => $request->title,
    'description'=> $request->description,
    'created_by' => 1,
    'created_at' => now(),         // now() = current timestamp helper
    'status'     => $request->status,
]);

// SELECT all (READ)
$statuses = DB::table('statuses')->get();      // collection of all rows

// SELECT one by primary key
$post = DB::table('post')->find($id);          // single row, or null

// UPDATE
DB::table('post')
    ->where('id', $id)                         // WHERE id = $id
    ->update([
        'title'      => $request->title,
        'updated_at' => now(),
    ]);
```

| Query Builder | SQL it generates |
|---------------|------------------|
| `DB::table('post')->get()` | `SELECT * FROM post` |
| `DB::table('post')->find($id)` | `SELECT * FROM post WHERE id = ?` |
| `->insert([...])` | `INSERT INTO ...` |
| `->where('id',$id)->update([...])` | `UPDATE ... WHERE id = ?` |
| `->where('id',$id)->delete()` | `DELETE ... WHERE id = ?` |

> **Note for your exam:** Many Laravel exams test **Eloquent** (`Post::all()`, `Post::find()`,
> model relationships). Your *project* doesn't use Eloquent — it uses the Query Builder. If the
> exam asks for Eloquent specifically, that's a separate topic to study; this guide reflects
> what you actually wrote. (Also note: your `post`/`statuses` tables were created directly in
> MySQL, not via `database/migrations`.)

---

## Lesson 11 — Full CRUD: the Posts Feature (everything together)

This ties Lessons 1–10 into one feature. Trace the flow.

### READ — list posts with their status name
Controller `PostController@index`:

```php
public function index()
{
    $posts = DB::table('post')
        ->leftJoin('statuses', 'post.status', 'statuses.id')     // join post.status -> statuses.id
        ->select('post.*',
                 'statuses.display_name as status_name',         // alias -> $post->status_name
                 'statuses.name as sname')                       // alias -> $post->sname
        ->get();
    $statuses = DB::table('statuses')->get();

    return view('post', compact('posts', 'statuses'));
}
```

View `post.blade.php` (the table) — note the aliases become object properties:

```blade
@foreach($posts as $post)
<tr>
    <td>{{ $post->title }}</td>
    <td>{{ $post->description }}</td>
    <td>{{ $post->created_at }}</td>
    <td>{{ $post->status_name }}</td>     {{-- the aliased column --}}
    <td>
        @if($post->sname != 'published')   {{-- only show edit on non-published --}}
            <a href="{{ route('post.showUpdate', $post->id) }}" class="bi bi-pencil-square"></a>
        @endif
    </td>
</tr>
@endforeach
```

### UPDATE — the two-step pattern
Updates are always **two routes**: one GET to show the pre-filled form, one PUT to save.

Routes:

```php
Route::get('/post/update/{id}',  [PostController::class, 'showUpdate'])->name('post.showUpdate');
Route::put('/post/update/{id}',  [PostController::class, 'updateSubmit'])->name('post.updateSubmit');
```

Step 1 — show the form. `PostController@showUpdate`:

```php
public function showUpdate($id)
{
    $statuses = DB::table('statuses')->get();
    $post     = DB::table('post')->find($id);
    return view('post-update', compact('statuses', 'post'));
}
```

The form `post-update.blade.php` — pre-filled, with the PUT spoof and selected option:

```blade
<form method="POST" action="{{ route('post.updateSubmit', $post->id) }}">
    @csrf
    @method('PUT')                          {{-- HTML forms can't do PUT; this fakes it --}}

    <input type="text" name="title" value="{{ $post->title }}">
    <textarea name="description">{{ $post->description }}</textarea>

    <select name="status">
        @foreach($statuses as $status)
            @if($post->status == $status->id)
                <option value="{{ $status->id }}" selected>{{ $status->display_name }}</option>
            @else
                <option value="{{ $status->id }}">{{ $status->display_name }}</option>
            @endif
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
```

Step 2 — save. `PostController@updateSubmit`:

```php
public function updateSubmit(Request $request, $id)
{
    $request->validate([
        'title'       => ['required'],
        'description' => ['required'],
        'status'      => ['required'],
    ]);

    DB::table('post')
        ->where('id', $id)
        ->update([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status,
            'updated_at'  => now(),
        ]);

    return redirect()->route('post.form');   // PRG pattern: redirect after a write
}
```

> **Rules:**
> - HTML forms only send GET/POST. To hit a PUT/PATCH/DELETE route, add **`@method('PUT')`**
>   inside the form (alongside `@csrf`).
> - After a successful write, **`redirect()->route('name')`** — never just return a view (stops
>   double-submits). This is the Post/Redirect/Get pattern.
> - `leftJoin` + `select('table.col as alias')` → access in Blade as `$row->alias`.

---

## Lesson 12 — Quick Syntax Reference Card

### Routes
```php
Route::get('/url', [Controller::class, 'method'])->name('route.name');
Route::post('/url', [Controller::class, 'method'])->name('route.name');
Route::put('/url/{id}', [Controller::class, 'method'])->name('route.name');
Route::group(['prefix' => 'user'], function(){ /* routes */ });
Route::fallback(function(){ /* 404 */ });
route('route.name', ['id' => 5]);   // build a URL from a name
```

### Validation rules you used
| Rule | Meaning |
|------|---------|
| `required` | must be present |
| `max:16` | string ≤ 16 chars |
| `min:2` | string ≥ 2 chars |
| `email` | must be a valid email |
| `ends_with:@microsoft.com` | must end with that text |
| custom msg key | `'field.rule' => 'message'` |

### Blade directives
| Echo / logic | Layout | Forms |
|--------------|--------|-------|
| `{{ $var }}` | `@extends('x')` | `@csrf` |
| `@if / @else / @endif` | `@section('x') ... @endsection` | `@method('PUT')` |
| `@foreach($a as $b) ... @endforeach` | `@yield('x')` | `{{ old('field') }}` |
| `@auth / @endauth` | `@include('partial')` | `$errors->all()` |

### Query Builder
```php
DB::table('t')->get();                       // all rows
DB::table('t')->find($id);                   // one by id
DB::table('t')->where('col', $v)->first();   // one by condition
DB::table('t')->insert([...]);               // create
DB::table('t')->where('id',$id)->update([...]); // update
DB::table('t')->where('id',$id)->delete();   // delete
DB::table('t')->leftJoin('u','t.x','u.id')->select('t.*','u.name as n')->get();
now();  Hash::make($pw);  Log::info('msg');
```

### Request → DB flow (the whole game)
```
HTML name="x"  →  $request->x  →  validate('x')  →  DB::table()->insert(['x' => $request->x])
```

---

Now go to **`02-PRACTICE-TEST.md`** and handwrite the answers before checking the key.
