@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="card shadow-lg border-0" style="max-width: 400px; width: 100%;">
        <div class="card-body p-4 bg-white rounded">
            <h2 class="text-center text-primary mb-4">{{ __('Iniciar Sesión') }}</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Correo Electrónico -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" 
                           required autocomplete="email" autofocus>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">{{ __('Contraseña') }}</label>
                    <input id="password" type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="current-password">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Recuérdame -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="remember">{{ __('Recuérdame') }}</label>
                </div>

                <!-- Botón de Iniciar Sesión -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        {{ __('Iniciar Sesión') }}
                    </button>
                </div>

                <!-- Enlace para recuperar contraseña -->
                @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="text-decoration-none text-primary fw-semibold" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                </div>
                @endif
            </form>

            <!-- Enlace para registro -->
            @if (Route::has('register'))
            <div class="text-center mt-4">
                <p class="mb-0">
                    {{ __('¿No tienes una cuenta?') }}
                    <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">
                        {{ __('Regístrate aquí') }}
                    </a>
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
