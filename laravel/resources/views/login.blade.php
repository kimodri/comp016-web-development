<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pricing Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite([
    'resources/sass/app.scss',
    'resources/css/login.css',
    'resources/js/app.js'
    ])
</head>

<body>
    <header style="background-color: #F9B2D7;">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Hotel? Trabago</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/#">Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="/#">Pricing</a></li>
                        <li class="nav-item"><a class="nav-link" href="/#">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 p-3">
                <div class="mt-5 container">
                    <form>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <button type="submit" class="btn custom-btn shadow">Login</button>
                        <a href="/#" class="ms-2">Forgot Password?</a>
                    </form>
                </div>
            </div>

            <div class="col-lg-8  p-3">
                <h2 class="text-center">Pricing</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 border p-3 mb-3">
                            <img src="{{ asset('src/6.png') }}" class="img-fluid">
                        </div>
                        <div class="col-lg-4 col-md-6 border p-3 mb-3">
                            <img src="{{ asset('src/1.jpg') }}" class="img-fluid">
                        </div>
                        <div class="col-lg-4 col-md-6 border p-3 mb-3">
                            <img src="{{ asset('src/2.jpg') }}" class="img-fluid">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 border p-3 mb-3">
                            <img src="{{ asset('src/3.jpg') }}" class="img-fluid">
                        </div>
                        <div class="col-lg-4 col-md-6 border p-3 mb-3">
                            <img src="{{ asset('src/4.jpg') }}" class="img-fluid">
                        </div>
                        <div class="col-lg-4 col-md-6 border p-3 mb-3">
                            <img src="{{ asset('src/5.jpg') }}" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <h4 class="text-center">Compare Plans</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Feature</th>
                                <th scope="col">Free Pro</th>
                                <th scope="col">Enterprise</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Feature 1</td>
                                <td><i class="bi bi-check"></i></td>
                                <td><i class="bi bi-check"></i></td>
                            </tr>
                            <tr>
                                <td>Feature 2</td>
                                <td><i class="bi bi-x"></i></td>
                                <td><i class="bi bi-check"></i></td>
                            </tr>
                            <tr>
                                <td>Feature 3</td>
                                <td><i class="bi bi-x"></i></td>
                                <td><i class="bi bi-x"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
