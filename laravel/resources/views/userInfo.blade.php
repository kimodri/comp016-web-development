<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="shadow container mt-5 p-2">
        <h1>User Form</h1>
        <form class="customForm" method="POST" action="{{route('user.submit')}}">
            @csrf
            @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{$error}}
                </div>
            @endforeach
            @endif
            <div>
                <div class="mb-3">
                    <label for="name">First Name:</label>
                    <input type="text" id="name" name="fname">
                </div>
                <div class="mb-3">
                    <label for="name">Middle Name:</label>
                    <input type="text" id="name" name="mname">
                </div>
                <div class="mb-3">
                    <label for="name">Last Name:</label>
                    <input type="text" id="name" name="lname">
                </div>
                <div class="mb-3">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">

                </div>
                <div class="mb-3">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <input type="submit" value="Submit" class="btn btn-warning">
            </div>
        </form>
    </div>
</body>

</html>