@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Propiedad</h1>
    <div class="card mb-4">
        <div class="card-header">
            {{ $propiedad->Direccion }}
        </div>
        <div class="card-body">
            <p><strong>Estado:</strong> {{ $propiedad->Estado }}</p>
            <p><strong>Municipio:</strong> {{ $propiedad->Municipio }}</p>
            <p><strong>Precio de Renta:</strong> ${{ number_format($propiedad->Precio_Renta, 2) }}</p>
            <p><strong>Tipo:</strong> {{ $propiedad->Tipo }}</p>
            <p><strong>Descripción:</strong> {{ $propiedad->Descripcion }}</p>

            @if($propiedad->imagenes->count() > 0)
                <div class="row mb-4">
                    @foreach($propiedad->imagenes as $imagen)
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $imagen->path) }}" class="img-fluid rounded" alt="Imagen de la propiedad">
                        </div>
                    @endforeach
                </div>
            @else
                <p>No hay imágenes disponibles para esta propiedad.</p>
            @endif
        </div>
    </div>

    <!-- Sección del Mapa -->
    <div class="card mb-4">
        <div class="card-header">Ubicación</div>
        <div class="card-body">
            <div id="map" style="height: 400px;"></div>
        </div>
    </div>

    <!-- Sección de Reseñas -->
    <div class="card mb-4">
        <div class="card-header">Reseñas</div>
        <div class="card-body">
            @if($propiedad->Reseñas)
                <p>{{ $propiedad->Reseñas }}</p>
            @else
                <p>No hay reseñas disponibles para esta propiedad.</p>
            @endif
        </div>
    </div>

    <!-- Sección de Calificación -->
    <div class="card">
        <div class="card-header">Calificación</div>
        <div class="card-body">
            @if($propiedad->Calificacion)
                <div>
                    <span style="font-size: 1.5rem; font-weight: bold;">{{ number_format($propiedad->Calificacion, 1) }}/5.0</span>
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $propiedad->Calificacion ? 'bi-star-fill' : 'bi-star' }}" style="color: gold;"></i>
                        @endfor
                    </div>
                </div>
            @else
                <p>Sin calificación disponible.</p>
                <div>
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star" style="color: gold;"></i>
                    @endfor
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Google Maps Script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3Zc0ynPPFO3t9YS4N6FAl_uWSaPTC0qc"></script>
<script>
    function initMap() {
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: "{{ $propiedad->Direccion }}" }, (results, status) => {
            if (status === "OK") {
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: results[0].geometry.location,
                });
                new google.maps.Marker({
                    position: results[0].geometry.location,
                    map: map,
                });
            } else {
                console.error("Error al cargar el mapa: " + status);
            }
        });
    }

    window.onload = initMap;
</script>
@endsection
