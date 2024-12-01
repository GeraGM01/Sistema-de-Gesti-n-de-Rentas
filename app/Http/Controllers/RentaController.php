<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentaController extends Controller
{
    public function rentar($id)
    {
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

        return redirect()->back()->with('success', '¡Has rentado la propiedad con éxito!');
    }

    public function misRentas()
    {
        $misRentas = Propiedad::where('rented_by', Auth::id())->get();
        return view('rentas.mis-rentas', compact('misRentas'));
    }
}
