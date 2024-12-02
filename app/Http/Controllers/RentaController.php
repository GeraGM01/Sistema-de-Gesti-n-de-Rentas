<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RentaController extends Controller
{
    public function rentar($id)
    {
        // Buscar la propiedad
        $propiedad = Propiedad::findOrFail($id);

        // Verificar si la propiedad está disponible para renta
        if ($propiedad->Estatus !== 'Disponible') {
            return redirect()->back()->with('error', 'Esta propiedad no está disponible para renta.');
        }

        // Actualizar la propiedad para asignar el usuario y marcarla como rentada
        $propiedad->update([
            'rented_by' => Auth::id(),
            'rented_at' => now(),
            'Estatus' => 'Rentado',
        ]);

        // Datos para el contrato
        $data = [
            'ciudad' => $propiedad->Estado . ', ' . $propiedad->Municipio,
            'fecha' => now()->format('d-m-Y'),
            'arrendador' => $propiedad->usuario->nombres . ' ' . $propiedad->usuario->apellido_paterno . ' ' . $propiedad->usuario->apellido_materno,
            'arrendatario' => Auth::user()->nombres. ' ' .Auth::user()->apellido_paterno. ' ' . Auth::user()->apellido_materno, 
            'direccion' => $propiedad->Direccion, 
            'inicio' => now()->format('d-m-Y'),
            'fin' => now()->addYear()->format('d-m-Y'), 
            'renta' => $propiedad->Precio_Renta, 
        ];

        // Generar el PDF del contrato usando la vista y los datos
        $pdf = Pdf::loadView('contrato', $data);

        return $pdf->download('contrato_renta_'.$propiedad->id.'.pdf');
    }

    public function misRentas()
    {
        $misRentas = Propiedad::where('rented_by', Auth::id())->get();
        return view('rentas.mis-rentas', compact('misRentas'));
    }
}
