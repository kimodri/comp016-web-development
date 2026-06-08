<!DOCTYPE html>

<head>
    <title>UHandle - @yield('title')</title> <!-- This has to be a placeholder -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                @if($pageName == 'login')
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="true" href="{{ route('login') }}">Login</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" aria-current="true" href="{{ route('login') }}">Login</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="#">Hotels</a>  <!-- You can use route() here -->
                </li>
                @if($pageName == 'dashboard')
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('getUsers') }}">Users</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('getUsers') }}">Users</a>
                    </li>
                @endif


            </ul>
        </div>
    </div>

    <div class='container'>
        @yield('content')
    </div>
</body>

</html>