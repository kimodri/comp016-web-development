<!DOCTYPE html>

<head>
    <title>UHandle - @yield('title')</title> <!-- This has to be a placeholder -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="true" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Hotels</a>  <!-- You can use route() here -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Users</a>
                </li>
            </ul>
        </div>
    </div>

    <div class='container'>
        @yield('content')
    </div>
</body>

</html>