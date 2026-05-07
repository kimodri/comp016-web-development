# comp016-web-development

`php artisan make:controller <controllerName>`

---

# Notes
## 03/16/26
The following topics were covered in recent sessions (latest commit `6c903a4` and onwards):

### 1. Logging in Laravel

All controllers now use `Illuminate\Support\Facades\Log` for logging. Laravel provides several log levels:

- `Log::info()` — general information (e.g., start/end of operations, computed values)
- `Log::debug()` — detailed debug messages (can be toggled on/off via config)
- `Log::error()` — error messages caught in exception handling

Logging was added to `AboutController`, `ContactController`, `HomeController`, `UserController`, `CalculateController`, and `UtilController`.

### 2. Error Handling (try-catch-finally)

`CalculateController` demonstrates proper exception handling:

- `try { ... } catch (Exception $e) { ... }` — catches general exceptions
- `try { ... } catch (Throwable $e) { ... }` — catches all throwables including `DivisionByZeroError`
- `finally { ... }` — runs whether the try block succeeds or fails

### 3. `dd()` — Die and Dump

Laravel's `dd()` helper outputs a variable's value and stops script execution. Useful for quick debugging:

```php
dd('Stop'); // prints "Stop" and halts
```
### 4. UtilController — Controller-to-Controller Interaction

A separate `UtilController` was created with `product()` and `quotient()` methods. `CalculateController` instantiates it to delegate multiplication and division:

```php
$util = new UtilController();
$product = $util->product($num1, $num2);
$quotient = $util->quotient($num1, $num2);
```

This demonstrates how one controller can use another's methods.

## 04/17/2026
### 4. Blade Views with Vite

The `@vite()` directive was added to `calculate.blade.php` for asset bundling:

```blade
@vite([
    'resources/sass/app.scss',
    'resources/js/app.js'
])
```

This integrates Vite as the frontend build tool for compiling Sass and JavaScript.

### 5. Bootstrap Integration

Bootstrap components used in `calculate.blade.php`:

- **Forms** — `form-label`, `form-control`, `mb-3`
- **Buttons** — `btn btn-danger`
- **Borders & Backgrounds** — `border border-danger`, `bg-success`
- **Icons** — Bootstrap Icons (`bi bi-airplane`)

### 6. CSS Styling in Blade

Different ways of applying styles demonstrated:

- **Inline `<style>` block** — class selectors (`.body-cont`), ID selectors (`#fNameLabel`), element selectors (`p`)
- **Inline styles** — `style="color: blue;"` directly on elements
- **Class/ID attributes** — `class="body-cont"`, `class="diff"`, `id="fNameLabel"`

### 7. Bootstrap Grid System & Responsiveness

The grid system uses 12 columns with responsive breakpoints:

- `col-lg-*` — large screens
- `col-md-*` — medium screens
- `col-sm-*` — small screens
- `col-xs-*` — extra-small screens

Example: `col-lg-12 col-md-4 col-sm-6 col-xs-4` means full-width on large, 1/3 on medium, 1/2 on small, 1/3 on extra-small.

## 04/30/2026
Changes from commit `5f0f774` (Midterm assignment) to `ed6d71d`:

### 1. Blade Layout Inheritance (`@extends`, `@section`, `@yield`, `@include`)

A common parent layout `resources/views/common/main.blade.php` was created to centralize the HTML skeleton (`<head>`, Vite assets, header, footer). Child views now inherit from it:

```blade
@extends("common.main")
@section("title", "calculate")
@section("content")
    {{-- page content --}}
@endsection
```

The parent layout uses `@yield("title")`, `@yield("content")`, and `@include('common.header')` / `@include('common.footer')` to compose the page.

`calculate.blade.php` and `login.blade.php` were refactored to extend `common.main` instead of repeating the full HTML boilerplate.

### 2. Common Partials

- `resources/views/common/header.blade.php` — Bootstrap navbar with dropdown.
- `resources/views/common/footer.blade.php` — fixed-bottom footer with copyright.

### 3. User Form (`userInfo.blade.php`)

A new view `userInfo.blade.php` displays a user registration form with fields for first/middle/last name, email, and password. `UserController@user` now returns this view instead of a plain string.

The form submits via `POST` to the `user.submit` route, includes `@csrf`, and renders validation errors using `@if($errors->any())` / `@foreach($errors->all() as $error)`.

### 4. Handling Form Submissions in `UserController`

#### The `Request` class

The `userSubmit` method type-hints `Illuminate\Http\Request` as a parameter. Laravel's service container automatically resolves and injects the current HTTP request — no need to instantiate it manually:

```php
use Illuminate\Http\Request;

public function userSubmit(Request $request){
    // ...
}
```

The `$request` object holds all incoming data (form fields, query strings, headers, files, cookies, etc.).

#### Accessing input

Form field values can be read directly as properties on `$request`, where the property name matches the `name` attribute of the HTML input:

```php
$request->fname   // value of <input name="fname">
$request->email   // value of <input name="email">
```

Equivalent alternatives include `$request->input('fname')` and `$request->all()`.

#### CSRF protection

Because the form submits via `POST`, the Blade form must include the `@csrf` directive. Laravel's `VerifyCsrfToken` middleware checks this token on every non-GET request — without it, the submission is rejected with a 419 error.

#### Validation via `$request->validate()`

Validation rules are passed as the first argument; custom error messages as the optional second argument:

```php
$request->validate([
    'fname' => ['required', 'max:16'],
    'lname' => ['required', 'min:2'],
    'email' => ['required', 'email', 'ends_with:@microsoft.com'],
], [
    'fname.required' => 'Hello first name required!',
    'lname.min' => "Bawal isa lang :)"
]);
```

If validation fails, Laravel automatically redirects the user back to the previous page and flashes the errors into the session, where they become available in the view as `$errors` (used by the `@if($errors->any())` block in `userInfo.blade.php`). If it passes, execution continues and the validated values are logged via `Log::info()`.

Custom messages are keyed as `field.rule` (e.g. `fname.required`, `lname.min`). Built-in rules used here:

- `required` — field must be present and non-empty
- `max:16` / `min:2` — string length constraints
- `email` — must be a valid email format
- `ends_with:@microsoft.com` — string must end with the given value

#### Debugging with `dd()`

The commented-out `// dd($request->fname);` line shows a common debugging pattern — dump a single request field and halt execution to inspect what was actually submitted before validation runs.

### 5. New Route

In `routes/web.php`, a `POST /user` route was added to handle the form submission:

```php
Route::post('/', [UserController::class, 'userSubmit'])->name('user.submit');
```

This pairs with the existing `GET /user` route under the `user` prefix group.
