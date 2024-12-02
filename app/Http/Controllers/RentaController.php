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

        // Enviar correo al arrendatario
        \Mail::to(Auth::user()->email)->send(new \App\Mail\ContratoRentaMail($data, $pdf));

        // Enviar correo al arrendador
        \Mail::to($propiedad->usuario->email)->send(new \App\Mail\ContratoRentaMailDueño([
            'ciudad' => $data['ciudad'],
            'direccion' => $data['direccion'],
            'inicio' => $data['inicio'],
            'fin' => $data['fin'],
            'renta' => $data['renta'],
            'mensaje' => 'Tu propiedad ha sido rentada.',
            ], $pdf));

        return $pdf->download('contrato_renta_'.$propiedad->id.'.pdf');

    }

    public function misRentas()
    {
        $misRentas = Propiedad::where('rented_by', Auth::id())->get();
        return view('rentas.mis-rentas', compact('misRentas'));
    }
    public function finalizarRenta(Request $request, $id)
    {
        // Validar datos del formulario
        $request->validate([
            'Reseña' => 'required|string|max:500',
            'Calificacion' => 'required|integer|min:1|max:5',
        ]);

        // Buscar la propiedad por ID
        $propiedad = Propiedad::findOrFail($id);

        // Verificar si la propiedad está rentada
        if (is_null($propiedad->rented_by)) {
            return redirect()->back()->withErrors('La propiedad no está rentada actualmente.');
        }

        // Guardar la reseña y calificación, y marcar como no rentada
        $propiedad->Reseñas = $request->input('Reseña');
        $propiedad->Calificacion = $request->input('Calificacion');
        $propiedad->rented_by = null; // La propiedad ya no está rentada
        $propiedad->Estatus = 'Disponible';
        $propiedad->save();

        return redirect()->back()->with('success', 'Gracias por tu opinión. La propiedad está ahora disponible.');
    }


}
