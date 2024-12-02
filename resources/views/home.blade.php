@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Título de la página -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Tus Casas De Renta</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarCasaModal">Agregar Casa</button>
    </div>

    <!--cards con la informacion de las casas-->
    @if ($casas->isEmpty())
<<<<<<< HEAD
        <!-- Mensaje si no hay casas -->
        <div class="alert alert-warning text-center" role="alert">
            No hay casas disponibles para mostrar en este momento.
        </div>
    @else
        <!-- Tarjetas de las casas -->
        <div class="row">
            @foreach ($casas as $casa)
                <div class="col-md-4 mb-4">
                    <div class="card h-100" id="card_img" style="cursor: pointer;" onclick="window.location='{{ route('casas.editar', $casa->id) }}'">
                    <!-- Imagen de fondo -->
                    <div class="card-img-top"
                    style="background-image: url('{{ asset('storage/' . $casa->imagenes->first()->path) }}');
                            background-size: contain; 
                            background-position: center;
                            background-repeat: no-repeat; 
                            height: 200px;">
                        </div>
                        
                        <!-- Información de la casa -->
                        <div class="card-body">
                            <h5 class="card-title">{{ $casa->Tipo }}  ${{ $casa->Precio_Renta }}.00</h5>
                            <p class="card-text">
                                <strong>Dirección:</strong> {{ $casa->Direccion }} <br>
                                <strong>Estatus:</strong> {{ $casa->Estatus }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
=======
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
>>>>>>> c2beaf4 (Pdf)
        </div>
    @endif
    

    <!-- Modal para agregar casa -->
    <div class="modal fade" id="agregarCasaModal" tabindex="-1" aria-labelledby="agregarCasaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('casas.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregarCasaModalLabel">Agregar Casa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Dirección -->
                        <div class="mb-3">
                            <label for="Direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="Direccion" name="Direccion" placeholder="Dirección" required>
                        </div>

                        <!-- Estado -->
                        <div class="mb-3">
                            <label for="Estado" class="form-label">Estado</label>
                            <select class="form-select" id="Estado" name="Estado" required>
                                <option value="" disabled selected>Selecciona un estado</option>
                                @foreach($estados as $estado => $municipios)
                                    <option value="{{ $estado }}">{{ $estado }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Municipio -->
                        <div class="mb-3">
                            <label for="Municipio" class="form-label">Municipio</label>
                            <select class="form-select" id="Municipio" name="Municipio" disabled required>
                                <option value="" disabled selected>Selecciona un municipio</option>
                            </select>
                        </div>

                        <!-- Tipo -->
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

                        <!-- Precio -->
                        <div class="mb-3">
                            <label for="Precio" class="form-label">Renta Mensual</label>
                            <input type="number" class="form-control" id="Precio" name="Precio" placeholder="Precio" min='1' required>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="Descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="Descripcion" name="Descripcion" rows="3" required></textarea>
                        </div>

                        <!-- Estado de la propiedad -->
                        <div class="mb-3">
                            <label for="EstadoPropiedad" class="form-label">Estatus de la propiedad</label>
                            <select class="form-select" id="EstadoPropiedad" name="EstadoPropiedad" required>
                                <option value="" disabled selected>Selecciona el estado de la propiedad</option>
                                <option value="Disponible">Disponible</option>
                                <option value="Rentado">Rentado</option>
                            </select>
                        </div>

                        <!-- Imágenes -->
                        <div id="imageInputsContainer">
                            <div class="mb-3" class="image-input">
                                <label for="images" class="form-label">Subir Imágenes</label>
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const estadoSelect = document.getElementById('Estado');
        const municipioSelect = document.getElementById('Municipio');
        const addImageButton = document.getElementById('addImageButton');
        const imageInputsContainer = document.getElementById('imageInputsContainer');

        // Agregar un nuevo campo de imagen al hacer clic en el botón
        addImageButton.addEventListener('click', () => {
            const newImageInput = document.createElement('div');
            newImageInput.classList.add('mb-3');
            newImageInput.innerHTML = `
                <label for="images" class="form-label">Subir Imágenes</label>
                <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
                <button type="button" class="btn btn-danger remove-image-btn">Eliminar</button>
            `;
            imageInputsContainer.appendChild(newImageInput);

            // Añadir el evento para eliminar el campo de imagen específico
            const removeButton = newImageInput.querySelector('.remove-image-btn');
            removeButton.addEventListener('click', () => {
                imageInputsContainer.removeChild(newImageInput);
            });
        });

        estadoSelect.addEventListener('change', async function() {
            const estado = this.value;
            municipioSelect.disabled = true;
            municipioSelect.innerHTML = '<option value="" disabled selected>Cargando municipios...</option>';

            try {
                const response = await fetch('{{ route("casas.municipios") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ estado })
                });

                const data = await response.json();
                if (response.ok) {
                    municipioSelect.innerHTML = '<option value="" disabled selected>Selecciona un municipio</option>';
                    data.municipios.forEach(municipio => {
                        municipioSelect.innerHTML += `<option value="${municipio}">${municipio}</option>`;
                    });
                    municipioSelect.disabled = false;
                } else {
                    municipioSelect.innerHTML = '<option value="" disabled>No se encontraron municipios</option>';
                }
            } catch (error) {
                console.error('Error al obtener municipios:', error);
                municipioSelect.innerHTML = '<option value="" disabled>Error al cargar municipios</option>';
            }
        });
    });
</script>
@endsection
