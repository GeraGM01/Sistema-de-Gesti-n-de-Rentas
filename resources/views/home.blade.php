@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Título de la página -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Propiedades Disponibles</h1>
        <!-- Mostrar botón de agregar propiedad si el usuario autenticado es 'arrendador' -->
        @auth
        @if(auth()->user()->rol === 'arrendador')
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarCasaModal">Agregar Propiedad</button>
        @endif
        @endauth
    </div>

    <!-- Mostrar mensaje si no hay casas -->
    @if ($casas->isEmpty())

        <!-- Mensaje si no hay casas -->
        <div class="alert alert-warning text-center" role="alert">
            No hay casas disponibles para mostrar en este momento.
        </div>

    @else
    <!-- Tarjetas de las propiedades -->
    <div class="row">
        @foreach ($casas as $casa)
        <div class="col-md-4 mb-4">
            <div class="card h-100" id="card_img" style="cursor: pointer;" @if(auth()->user()->rol === 'arrendador')
                onclick="window.location='{{ route('casas.editar', $casa->id) }}'"
            @endif">
                <!-- Imagen de la propiedad -->
                <div class="card-img-top"
                    style="background-image: url('{{ asset('storage/' . $casa->imagenes->first()->path) }}');
                           background-size: cover; 
                           background-position: center;
                           height: 200px;">
                </div>
                <!-- Detalles de la propiedad -->
                <div class="card-body">
                    <h5 class="card-title">{{ $casa->Tipo }} - ${{ number_format($casa->Precio_Renta, 2) }}</h5>
                    <p class="card-text">
                        <strong>Dirección:</strong> {{ $casa->Direccion }}<br>
                        <span class="badge bg-primary">{{ $casa->Estatus }}</span>
                    </p>

                    <!-- Opciones si la propiedad está disponible -->
                    @if ($casa->Estatus === 'Disponible')
                    <div class="d-flex gap-2">
                        <form action="{{ route('propiedades.rentar', $casa->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Rentar</button>
                        </form>
                        <a href="{{ route('propiedades.Detalles', $casa->id) }}" class="btn btn-primary">Ver Detalles</a>
                    </div>
                    @endif
                </div>

            @endforeach

    <div class="alert alert-warning text-center" role="alert">
        No hay propiedades disponibles en este momento.
    </div>
    @else
    <!-- Tarjetas de las propiedades -->
    <div class="row">
        @foreach ($casas as $casa)
        <div class="col-md-4 mb-4">
            <div class="card h-100" id="card_img" style="cursor: pointer;" @if(auth()->user()->rol === 'arrendador')
                onclick="window.location='{{ route('casas.editar', $casa->id) }}'"
            @endif">
                <!-- Imagen de la propiedad -->
                <div class="card-img-top"
                    style="background-image: url('{{ asset('storage/' . $casa->imagenes->first()->path) }}');
                           background-size: cover; 
                           background-position: center;
                           height: 200px;">
                </div>
                <!-- Detalles de la propiedad -->
                <div class="card-body">
                    <h5 class="card-title">{{ $casa->Tipo }} - ${{ number_format($casa->Precio_Renta, 2) }}</h5>
                    <p class="card-text">
                        <strong>Dirección:</strong> {{ $casa->Direccion }}<br>
                        <span class="badge bg-primary">{{ $casa->Estatus }}</span>
                    </p>

                    <!-- Opciones si la propiedad está disponible -->
                    @if ($casa->Estatus === 'Disponible')
                    <div class="d-flex gap-2">
                        <form action="{{ route('propiedades.rentar', $casa->id) }}" method="POST">
                            @csrf
                            @if(auth()->user()->rol === 'arrendatario')
                            <button type="submit" class="btn btn-success">Rentar</button>
                            @endif
                        </form>
                        <a href="{{ route('propiedades.Detalles', $casa->id) }}" class="btn btn-primary">Ver Detalles</a>
                    </div>
                    @endif
                </div>
            </div>

        </div>
        @endforeach
    </div>
    @endif

    <!-- Modal para agregar propiedad -->
    @auth
    <div class="modal fade" id="agregarCasaModal" tabindex="-1" aria-labelledby="agregarCasaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('casas.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregarCasaModalLabel">Agregar Propiedad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Campos del formulario -->
                        <div class="mb-3">
                            <label for="Direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="Direccion" name="Direccion" required>
                        </div>

                        <div class="mb-3">
                            <label for="Estado" class="form-label">Estado</label>
                            <select class="form-select" id="Estado" name="Estado" required>
                                <option value="" disabled selected>Selecciona un estado</option>
                                @foreach($estados as $estado => $municipios)
                                <option value="{{ $estado }}">{{ $estado }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="Municipio" class="form-label">Municipio</label>
                            <select class="form-select" id="Municipio" name="Municipio" disabled required>
                                <option value="" disabled selected>Selecciona un municipio</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="Tipo" class="form-label">Tipo de propiedad</label>
                            <select class="form-select" id="Tipo" name="Tipo" required>
                                <option value="" disabled selected>Selecciona el tipo</option>
                                <option value="Casa">Casa</option>
                                <option value="Departamento">Departamento</option>
                                <option value="Condominio">Condominio</option>
                                <option value="Oficina">Oficina</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="Precio" class="form-label">Renta Mensual</label>
                            <input type="number" class="form-control" id="Precio" name="Precio" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="Descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="Descripcion" name="Descripcion" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="EstadoPropiedad" class="form-label">Estatus</label>
                            <select class="form-select" id="EstadoPropiedad" name="EstadoPropiedad" required>
                                <option value="" disabled selected>Selecciona el estado</option>
                                <option value="Disponible">Disponible</option>
                                <option value="Rentado">Rentado</option>
                            </select>
                        </div>

                        <div id="imageInputsContainer">
                            <div class="mb-3">
                                <label class="form-label">Subir Imágenes</label>
                                <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
                            </div>
                        </div>
                        <button type="button" id="addImageButton" class="btn btn-secondary">Agregar más imágenes</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const estadoSelect = document.getElementById('Estado');
    const municipioSelect = document.getElementById('Municipio');
    const addImageButton = document.getElementById('addImageButton');
    const imageInputsContainer = document.getElementById('imageInputsContainer');

    // Agregar más campos de imágenes
    addImageButton.addEventListener('click', () => {
        const imageGroup = document.createElement('div');
        imageGroup.classList.add('mb-3');
        imageGroup.innerHTML = `
            <input type="file" class="form-control" name="images[]" accept="image/*">
            <button type="button" class="btn btn-danger mt-2 remove-image-btn">Eliminar</button>`;
        imageInputsContainer.appendChild(imageGroup);

        imageGroup.querySelector('.remove-image-btn').addEventListener('click', () => {
            imageGroup.remove();
        });
    });

    // Cargar municipios al seleccionar un estado
    estadoSelect.addEventListener('change', async function () {
        municipioSelect.disabled = true;
        municipioSelect.innerHTML = '<option value="" disabled selected>Cargando municipios...</option>';

        try {
            const response = await fetch('{{ route("casas.municipios") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ estado: this.value }),
            });
            const data = await response.json();

            municipioSelect.innerHTML = '<option value="" disabled selected>Selecciona un municipio</option>';
            data.municipios.forEach((municipio) => {
                municipioSelect.innerHTML += `<option value="${municipio}">${municipio}</option>`;
            });
            municipioSelect.disabled = false;
        } catch (error) {
            municipioSelect.innerHTML = '<option value="" disabled>Error al cargar municipios</option>';
        }
    });
});
</script>
@endsection
