<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema de Rentas de Casas</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    </head>
    <body class="bg-light text-dark font-sans">
        <!-- Header -->
        <header class="py-4 bg-primary text-white">
            <div class="container d-flex justify-content-between align-items-center">
                <h1 class="h3 fw-bold">Sistema de Rentas de Casas</h1>
                @if (Route::has('login'))
                    <nav>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white text-decoration-none me-3">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white text-decoration-none me-3">Iniciar sesión</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-white text-decoration-none">Registrarse</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Encuentra la casa perfecta para vivir</h2>
                <p class="fs-5">Nuestro sistema te permite buscar y gestionar propiedades de alquiler de forma rápida y sencilla.</p>
            </div>

            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">Explorar Propiedades</h5>
                            <p class="card-text">Busca casas en renta según tus necesidades y preferencias.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">Publicar Propiedades</h5>
                            <p class="card-text">Si eres propietario, publica tus casas o departamentos para encontrar arrendatarios rápidamente.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">Gestionar Rentas</h5>
                            <p class="card-text">Administra los detalles de tus rentas, pagos y contratos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-4 bg-primary text-white text-center">
            <p class="mb-1">Sistema de Rentas de Casas &copy; {{ date('Y') }}</p>
            <small>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</small>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
