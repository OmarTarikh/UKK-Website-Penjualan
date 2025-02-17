<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #0d6efd, #004085);
            min-height: 100vh;
        }
        .navbar {
            background: transparent !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark w-100 position-fixed top-0">
        <div class="container">
            <a class="navbar-brand" href="#">Website Penjualan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="btn btn-outline-light" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-light ms-2" href="{{ route('register') }}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <section class="d-flex flex-column justify-content-center align-items-center text-center vh-100 text-white">
        <h1 class="display-4 fw-bold">Selamat Datang di Website Penjualan</h1>
        <p>Aplikasi Berbasis website yang dibuat dengan framework laravel blade templating yang dibuat untuk sistem pejualan.</p>
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Get Started</a>
    </section>
    
    <section id="about" class="d-flex flex-column justify-content-center align-items-center text-center vh-100 text-white">
        <div class="text-center">
            <h2 class="mb-2">About</h2>
            <p style="max-width: 600px; margin: auto;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
    </section>
        
    <section id="contact" class="d-flex flex-column justify-content-center align-items-center text-center vh-100 text-white">
        <div class="text-center">
            <h2>Contact</h2>
            <p style="max-width: 600px; margin: auto;">Email: aleser187@gmail.com</p>
            <p style="max-width: 600px; margin: auto;">Telepon: +62 821 7087 6802</p>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>