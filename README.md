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

