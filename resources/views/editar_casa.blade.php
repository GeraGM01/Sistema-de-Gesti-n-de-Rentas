@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="fw-bold">Editar Casa</h1>

    <!-- Mostrar errores de validación -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario para editar la casa -->
    <form action="{{ route('casas.actualizar', $casa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    
        <!-- Dirección -->
        <div class="mb-3">
            <label for="Direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="Direccion" name="Direccion" value="{{ old('Direccion', $casa->Direccion) }}" required>
        </div>
    
        <!-- Estado -->
        <div class="mb-3">
            <label for="Estado" class="form-label">Estado</label>
            <select class="form-select" id="Estado" name="Estado" required>
                <option value="" disabled>Selecciona un estado</option>
                @foreach ($estados as $estado => $municipios)
                    <option value="{{ $estado }}" {{ old('Estado', $casa->Estado) == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                @endforeach
            </select>
        </div>
    
        <!-- Municipio -->
        <div class="mb-3">
            <label for="Municipio" class="form-label">Municipio</label>
            <input type="text" class="form-control" id="Municipio" name="Municipio" value="{{ old('Municipio', $casa->Municipio) }}" required>
        </div>
    
        <!-- Tipo -->
        <div class="mb-3">
            <label for="Tipo" class="form-label">Tipo de Casa</label>
            <select class="form-select" id="Tipo" name="Tipo" required>
                <option value="" disabled>Selecciona un tipo</option>
                <option value="Residencial" {{ old('Tipo', $casa->Tipo) == 'Residencial' ? 'selected' : '' }}>Casa</option>
                <option value="Comercial" {{ old('Tipo', $casa->Tipo) == 'Comercial' ? 'selected' : '' }}>Departamento</option>
                <option value="Comercial" {{ old('Tipo', $casa->Tipo) == 'Comercial' ? 'selected' : '' }}>Condominio</option>
                <option value="Comercial" {{ old('Tipo', $casa->Tipo) == 'Comercial' ? 'selected' : '' }}>Oficina</option>
            </select>
        <!-- Precio de renta -->
        <div class="mb-3">
            <label for="Precio_Renta" class="form-label">Precio de Renta</label>
            <input type="number" class="form-control" id="Precio_Renta" name="Precio_Renta" value="{{ old('Precio_Renta', $casa->Precio_Renta) }}" step="0.01" required>
        </div>
    
        <!-- Descripción -->
        <div class="mb-3">
            <label for="Descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="Descripcion" name="Descripcion" rows="5" required>{{ old('Descripcion', $casa->Descripcion) }}</textarea>
        </div>
    
        <!-- Estatus -->
        <div class="mb-3">
            <label for="Estatus" class="form-label">Estatus</label>
            <select class="form-select" id="Estatus" name="Estatus" required>
                <option value="" disabled>Selecciona un estatus</option>
                <option value="Disponible" {{ old('Estatus', $casa->Estatus) == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="Rentada" {{ old('Estatus', $casa->Estatus) == 'Rentada' ? 'selected' : '' }}>Rentada</option>
            </select>
        </div>
    
        <!-- Imágenes actuales -->
        <div class="mb-3">
            <label class="form-label">Imágenes actuales</label>
            <div id="currentImagesContainer" class="row g-3">
                @foreach ($casa->imagenes as $imagen)
                    <div class="col-md-4 image-container" data-image-id="{{ $imagen->id }}">
                        <div class="card position-relative">
                            <img src="{{ asset('storage/' . $imagen->path) }}" alt="Imagen" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <button type="button" class="btn btn-danger position-absolute top-0 end-0 remove-image-btn"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    
        <!-- Subir nuevas imágenes -->
        <div class="mb-3">
            <label for="nuevas_imagenes" class="form-label">Nuevas Imágenes</label>
            <div id="imageInputsContainer">
                <input type="file" name="nuevas_imagenes[]" class="form-control mb-2" accept="image/*">
            </div>
            <button type="button" id="addImageButton" class="btn btn-secondary mt-2">Agregar más imágenes</button>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-danger me-3" id="deleteButton">Eliminar Casa</button>
            <button type="submit" class="btn btn-primary me-3">Guardar cambios</button>
            <a href="{{ route('home') }}" class="btn btn-warning">Cancelar</a>
        </div>
    </form>

    <!-- Formulario oculto para eliminar la casa -->
    <form action="{{ route('casas.eliminar', $casa->id) }}" method="POST" id="delete-form" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<!-- Script para manejo de imágenes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para actualizar la visibilidad del botón de eliminar
        function updateRemoveButtonVisibility() {
            const imageContainers = document.querySelectorAll('.image-container');
            imageContainers.forEach(container => {
                const removeButton = container.querySelector('.remove-image-btn');
                // Si hay más de una imagen, mostrar el botón eliminar
                if (imageContainers.length > 1) {
                    removeButton.style.display = 'block';
                } else {
                    // Si solo queda una imagen, ocultar el botón eliminar
                    removeButton.style.display = 'none';
                }
            });
        }

        // Llamar a la función al cargar la página para asegurar que la visibilidad está correcta
        updateRemoveButtonVisibility();

        // Eliminar imagen actual
        document.querySelectorAll('.remove-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const imageContainer = this.closest('.image-container');
                const imageId = imageContainer.getAttribute('data-image-id');

                fetch(`/imagenes/eliminar/${imageId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          imageContainer.remove();
                          // Actualizar la visibilidad del botón de eliminar después de eliminar una imagen
                          updateRemoveButtonVisibility();
                      } else {
                          alert('Error al eliminar la imagen.');
                      }
                  });
            });
        });

        // Agregar más inputs para imágenes nuevas
        const addImageButton = document.getElementById('addImageButton');
        const imageInputsContainer = document.getElementById('imageInputsContainer');
        addImageButton.addEventListener('click', function() {
            const newImageInput = document.createElement('input');
            newImageInput.type = 'file';
            newImageInput.name = 'nuevas_imagenes[]';
            newImageInput.className = 'form-control mb-2';
            newImageInput.accept = 'image/*';
            imageInputsContainer.appendChild(newImageInput);
        });

        // Confirmación y eliminación de la casa
        const deleteButton = document.getElementById('deleteButton');
        deleteButton.addEventListener('click', function() {
            if (confirm('¿Estás seguro de que deseas eliminar esta casa y todas sus imágenes?')) {
                document.getElementById('delete-form').submit();
            }
        });
    });
</script>
@endsection
