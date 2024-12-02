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
                        <div class="card-body">
                            <h5 class="card-title">{{ $renta->Tipo }} - ${{ $renta->Precio_Renta }}</h5>
                            <p>
                                <strong>Dirección:</strong> {{ $renta->Direccion }}<br>
                                <strong>Fecha de Renta:</strong> {{ $renta->rented_at }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
