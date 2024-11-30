<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Propiedad;
use App\Models\imagen;


class CasaController extends Controller
{
    public function index()
    {
        // URL de la API
        $apiUrl = 'https://raw.githubusercontent.com/martinciscap/json-estados-municipios-mexico/master/estados-municipios.json';

        // Hacer una solicitud GET a la API
        $response = Http::get($apiUrl);

        // Validar si la solicitud falló
        if ($response->failed()) {
            return back()->withErrors(['error' => 'No se pudo obtener la información de estados y municipios.']);
        }

        // Obtener los datos en formato JSON
        $estadosMunicipios = $response->json();

       // Obtener las propiedades del usuario con ID_Usuario == 1 y su primera imagen
        $casas = Propiedad::where('ID_Usuario', 1)->with('imagenes')->get(); // Cargar las imágenes sin ordenarlas
        
        

        // Pasar los datos a la vista
        return view('casas', [
            'estados' => $estadosMunicipios,
            'casas' => $casas,
        ]);
    }

    public function obtenerMunicipios(Request $request)
    {
        // Validar el estado enviado
        $estadoSeleccionado = $request->input('estado');
        if (!$estadoSeleccionado) {
            return response()->json(['error' => 'No se proporcionó un estado válido.'], 400);
        }

        // URL de la API
        $apiUrl = 'https://raw.githubusercontent.com/martinciscap/json-estados-municipios-mexico/master/estados-municipios.json';

        // Obtener datos de la API
        $response = Http::get($apiUrl);
        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo obtener la información de municipios.'], 500);
        }

        // Buscar los municipios del estado seleccionado
        $estadosMunicipios = $response->json();
        if (isset($estadosMunicipios[$estadoSeleccionado])) {
            return response()->json(['municipios' => $estadosMunicipios[$estadoSeleccionado]]);
        }

        return response()->json(['error' => 'Estado no encontrado.'], 404);
    }


    // Función para guardar la casa en la base de datos sin usar un modelo
    public function guardar(Request $request)
    {

        $nuevaCasa = new Propiedad();
        $nuevaCasa->ID_Usuario = 1; // Asignar un usuario por defecto, puedes personalizar esto 
        $nuevaCasa->direccion = $request->Direccion;
        $nuevaCasa->estado = $request->Estado;
        $nuevaCasa->municipio = $request->Municipio;
        $nuevaCasa->precio_renta = $request->Precio;
        $nuevaCasa->tipo = $request->Tipo;
        $nuevaCasa->estatus = $request->EstadoPropiedad;
        $nuevaCasa->descripcion = $request->Descripcion;
        $nuevaCasa->save(); // Guardar la casa en la base de datos

        
       
        // Manejo de las imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Guardar la imagen en el almacenamiento
                $path = $image->store('casas', 'public');

                // Crear una nueva instancia del modelo Imagen
                $nuevaImagen = new imagen();
                $nuevaImagen->propiedad_id = $nuevaCasa->id; // Relación con la casa creada
                $nuevaImagen->path = $path;
                $nuevaImagen->save(); // Guardar la imagen en la base de datos
            }
        }


        // Redirigir con un mensaje de éxito
        return redirect()->route('casas.index')->with('success', 'Casa agregada correctamente.');
    }

}
