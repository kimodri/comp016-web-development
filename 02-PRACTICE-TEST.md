# Handwritten Code Reviewer — Practice Test

> **How to use this:** Cover the **Answer Key** (Section 5, at the bottom). Handwrite each
> answer on paper — no IDE, no autocomplete. Then check yourself. Every question is based on
> the real code in your `laravel/` project. Pay attention to exact spelling, brackets, arrows
> (`->`), and semicolons — that's what the exam grades.
>
> Companion reference: `01-LARAVEL-GUIDE.md`.

---

## Section 1 — Fill-in-the-Blank Architecture (Controllers & Routes)

### Q1.1 — The User registration route
You have this form in `userInfo.blade.php`:

```blade
<form class="customForm" method="POST" action="{{ route('user.submit') }}">
    @csrf
    <input type="text"     name="fname">
    <input type="text"     name="mname">
    <input type="text"     name="lname">
    <input type="email"    name="email">
    <input type="password" name="password">
    <input type="submit" value="Submit">
</form>
```

The form posts to a route named `user.submit`, which lives inside this group:

```php
Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'user'])->name('user');

    // ____________________________________________  <-- (a) WRITE THIS ROUTE

});
```

**(a)** Write the missing route line that sends a POST to `UserController@userSubmit`,
named `user.submit`.

---

### Q1.2 — The validation + save logic
Here is the controller method skeleton. Fill in the two blanks.

```php
public function userSubmit(Request $request){

    // (a) Validate: fname required & max 16; lname required & min 2;
    //     email required, valid email, must end with @microsoft.com.
    //     Custom message for fname.required = 'Hello first name required!'
    $request->__________________________________________________;

    // (b) Insert a row into the 'users' table using the request fields.
    //     Hash the password. (fname, mname, lname, email, password)
    DB::__________________________________________________;

    $users = DB::table('users')->get();
    return $users;
}
```

---

### Q1.3 — The Post update routes (GET + PUT)
The edit feature needs **two** routes pointing at `PostController`: one GET to show the
pre-filled form (`showUpdate`, named `post.showUpdate`) and one PUT to save
(`updateSubmit`, named `post.updateSubmit`). Both use `/post/update/{id}`.

```php
// (a) GET route -> showUpdate
// ______________________________________________________________

// (b) PUT route -> updateSubmit
// ______________________________________________________________
```

---

## Section 2 — Blade Syntax & Data Passing

### Q2.1 — Render the posts table
This controller method runs:

```php
public function index()
{
    $posts = DB::table('post')
        ->leftJoin('statuses', 'post.status', 'statuses.id')
        ->select('post.*',
                 'statuses.display_name as status_name',
                 'statuses.name as sname')
        ->get();
    $statuses = DB::table('statuses')->get();

    return view('post', compact('posts', 'statuses'));
}
```

In `post.blade.php`, the `<thead>` is already written. **Handwrite the `<tbody>`** that loops
over `$posts` and prints, in `<td>`s: title, description, created_at, and the status's
display name. In the last cell, show an edit link to `route('post.showUpdate', $post->id)`
**only if** the post's status name (`sname`) is not `'published'`.

```blade
<tbody>
    <!-- WRITE THE LOOP HERE -->
</tbody>
```

### Q2.2 — Render the status dropdown
Still in `post.blade.php`, handwrite a `<select name="status">` whose `<option>`s are built
by looping over `$statuses`. Each option's `value` is the status id and its visible text is
the status `display_name`.

---

## Section 3 — Query Builder & Data Retrieval

> *Exam caveat:* your project uses the **Query Builder** (`DB::table()`), so these answers use
> it. If your exam specifically asks for **Eloquent** (e.g. `Post::all()`, `Post::find($id)`,
> model relationships), study that separately — this project doesn't use it.

Write the exact Query Builder statement for each requirement:

**Q3.1** — Get **all** rows from the `statuses` table into `$statuses`.

**Q3.2** — Get a **single** post whose primary key is `$id` into `$post`.

**Q3.3** — Insert a new user into the `users` table with `fname`, `mname`, `lname`, `email`
from `$request`, and a **hashed** `password`.

**Q3.4** — Update the `post` row where `id` equals `$id`, setting `title`, `description`,
`status` from `$request`, and `updated_at` to the current time.

**Q3.5** — Get all posts, **left-joining** the `statuses` table (`post.status` = `statuses.id`)
and selecting all post columns plus `statuses.display_name` aliased as `status_name`.

---

## Section 4 — Code Tracing & Debugging

Each snippet below is **broken**. Identify the bug and write the corrected line(s).

### Q4.1
```blade
<form method="POST" action="{{ route('user.submit') }}">
    <input type="text" name="fname">
    <input type="submit" value="Submit">
</form>
```
Submitting this form gives a **419 Page Expired** error. What's missing? Fix it.

### Q4.2
```blade
<form method="POST" action="{{ route('post.updateSubmit', $post->id) }}">
    @csrf
    <input type="text" name="title" value="{{ $post->title }}">
    <button type="submit">Save</button>
</form>
```
The route `post.updateSubmit` is defined with `Route::put(...)`, but submitting this form
gives a **405 Method Not Allowed**. What single line is missing, and where?

### Q4.3
```blade
<input type="hidden" value="$post->id" name="id">
```
This hidden field renders the literal text `$post->id` instead of the actual id number.
Fix it.

### Q4.4
The controller does:
```php
return view('calculate', compact('sum', 'difference', 'product'));
```
The view contains:
```blade
<p>Quotient: {{ $quotient }}</p>
```
The page crashes with **Undefined variable $quotient**. Explain why and give two possible fixes.

### Q4.5
```php
$request->validate([
    'email' => ['required', 'email', 'endswith:@microsoft.com'],
]);
```
The `@microsoft.com` restriction never works (the rule is ignored / errors). What's the bug? Fix it.

### Q4.6
```php
Route::get('/post', [PostController::class, 'store'])->name('post');
```
The post-creation form (`method="POST" action="{{ route('post') }}"`) submits but the data is
never saved and you get a **405** or the wrong method runs. What's wrong with this route for a
form submission? Fix it.

---
---

# Section 5 — ANSWER KEY

> Try everything above first. Solutions below.

### A1.1
```php
Route::post('/', [UserController::class, 'userSubmit'])->name('user.submit');
```
*Inside the `['prefix' => 'user']` group, `'/'` becomes the URL `/user`. POST verb because the form submits data.*

### A1.2
**(a)** Validation:
```php
$request->validate([
    'fname' => ['required', 'max:16'],
    'lname' => ['required', 'min:2'],
    'email' => ['required', 'email', 'ends_with:@microsoft.com'],
], [
    'fname.required' => 'Hello first name required!',
]);
```
**(b)** Insert:
```php
DB::table('users')->insert([
    'fname'    => $request->fname,
    'mname'    => $request->mname,
    'lname'    => $request->lname,
    'email'    => $request->email,
    'password' => Hash::make($request->password),
]);
```
*Custom messages are keyed `'field.rule'`. Passwords must be hashed with `Hash::make()`.*

### A1.3
```php
Route::get('/post/update/{id}', [PostController::class, 'showUpdate'])->name('post.showUpdate');
Route::put('/post/update/{id}', [PostController::class, 'updateSubmit'])->name('post.updateSubmit');
```
*Same URL, different verbs: GET shows the form, PUT saves it.*

### A2.1
```blade
<tbody>
    @foreach($posts as $post)
    <tr>
        <td>{{ $post->title }}</td>
        <td>{{ $post->description }}</td>
        <td>{{ $post->created_at }}</td>
        <td>{{ $post->status_name }}</td>
        <td>
            @if($post->sname != 'published')
                <a href="{{ route('post.showUpdate', $post->id) }}" class="bi bi-pencil-square"></a>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>
```
*`status_name` and `sname` are the aliases set in the controller's `select()`.*

### A2.2
```blade
<select class="form-select" name="status">
    <option selected></option>
    @foreach($statuses as $status)
        <option value="{{ $status->id }}">{{ $status->display_name }}</option>
    @endforeach
</select>
```

### A3.1
```php
$statuses = DB::table('statuses')->get();
```

### A3.2
```php
$post = DB::table('post')->find($id);
```

### A3.3
```php
DB::table('users')->insert([
    'fname'    => $request->fname,
    'mname'    => $request->mname,
    'lname'    => $request->lname,
    'email'    => $request->email,
    'password' => Hash::make($request->password),
]);
```

### A3.4
```php
DB::table('post')
    ->where('id', $id)
    ->update([
        'title'       => $request->title,
        'description' => $request->description,
        'status'      => $request->status,
        'updated_at'  => now(),
    ]);
```

### A3.5
```php
$posts = DB::table('post')
    ->leftJoin('statuses', 'post.status', 'statuses.id')
    ->select('post.*', 'statuses.display_name as status_name')
    ->get();
```

### A4.1
**Missing `@csrf`.** Laravel rejects POST/PUT/DELETE forms without a CSRF token (419 error). Fix:
```blade
<form method="POST" action="{{ route('user.submit') }}">
    @csrf
    ...
</form>
```

### A4.2
**Missing `@method('PUT')`.** HTML forms can only send GET/POST, so the PUT route never matches (405). Add it right after `@csrf`:
```blade
@csrf
@method('PUT')
```

### A4.3
The value is in quotes as literal text, so Blade never evaluates it. Use `{{ }}`:
```blade
<input type="hidden" value="{{ $post->id }}" name="id">
```

### A4.4
`$quotient` was **never passed to the view** — `compact('sum', 'difference', 'product')` does
not include it, so the view can't see it (variable scope). Two fixes:
1. Add it in the controller: `compact('sum', 'difference', 'product', 'quotient')`.
2. Or remove/guard the line in the view (e.g. `{{ $quotient ?? '' }}`).

### A4.5
The rule name is wrong. It's **`ends_with`** (with an underscore), and it needs the value after a colon:
```php
'email' => ['required', 'email', 'ends_with:@microsoft.com'],
```

### A4.6
The route uses `Route::get`, but a form with `method="POST"` needs a **POST** route. A GET route
won't accept the submission. Fix:
```php
Route::post('/post', [PostController::class, 'store'])->name('post');
```
*(In your real project you actually have both: `Route::get('/post', ...'index')->name('post.form')` to show the page and `Route::post('/post', ...'store')->name('post')` to save.)*

---

### Scoring guide
- **Section 1–2 (architecture + blade):** these are the highest-value, most-likely exam
  questions. Aim to write them perfectly from memory.
- **Section 3 (query builder):** memorize the 5 verbs — `get`, `find`, `insert`, `update`,
  `delete` — and the `where('id', $id)` clause before update/delete.
- **Section 4 (debugging):** the classic exam bugs are **missing `@csrf`**, **missing
  `@method('PUT')`**, **forgetting `{{ }}`**, and **un-passed variables**. Know these cold.
