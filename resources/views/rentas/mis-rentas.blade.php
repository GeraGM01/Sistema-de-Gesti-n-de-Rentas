@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="fw-bold">Mis Propiedades Rentadas</h1>
    @if ($misRentas->isEmpty())
        <div class="alert alert-warning text-center">
            No has rentado ninguna propiedad aún.
        </div>
    @else
        <div class="row">
            @foreach ($misRentas as $renta)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if ($renta->imagenes->count() > 0)
                            <img src="{{ asset('storage/' . $renta->imagenes->first()->path) }}" class="card-img-top img-fluid" alt="Imagen de la propiedad">
                        @else
                            <img src="{{ asset('images/default-house.jpg') }}" class="card-img-top img-fluid" alt="Imagen por defecto">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $renta->Tipo }} - ${{ number_format($renta->Precio_Renta, 2) }}</h5>
                            <p>
                                <strong>Dirección:</strong> {{ $renta->Direccion }}<br>
                                <strong>Fecha de Renta:</strong> {{ $renta->rented_at }}
                            </p>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#valoracionModal-{{ $renta->id }}">
                                Finalizar Renta
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal de valoración -->
                <div class="modal fade" id="valoracionModal-{{ $renta->id }}" tabindex="-1" aria-labelledby="valoracionLabel-{{ $renta->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('propiedades.finalizarRenta', $renta->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="reseña" class="form-label">Reseña</label>
                                        <textarea name="Reseña" id="reseña" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="calificacion" class="form-label">Calificación</label>
                                        <select name="Calificacion" id="calificacion" class="form-select" required>
                                            <option value="5">5 estrellas</option>
                                            <option value="4">4 estrellas</option>
                                            <option value="3">3 estrellas</option>
                                            <option value="2">2 estrellas</option>
                                            <option value="1">1 estrella</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Finalizar Renta</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
