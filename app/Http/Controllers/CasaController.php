<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Propiedad;
use App\Models\imagen;
use Illuminate\Support\Facades\Auth;


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
        $user = Auth::user();

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

    public function editar($id)
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
        $casa = Propiedad::findOrFail($id);
        // Pasar los datos a la vista
        return view('editar_casa', [
            'estados' => $estadosMunicipios,
            'casa' => $casa,
        ]);
    }

    public function actualizar(Request $request, $id)
    {

        $casa = Propiedad::findOrFail($id); // Encontrar la casa por su ID

        // Validar y actualizar los datos
        $casa->direccion = $request->Direccion;
        $casa->estado = $request->Estado;
        $casa->municipio = $request->Municipio;
        $casa->precio_renta = $request->Precio_Renta;
        $casa->tipo = $request->Tipo;
        $casa->estatus = $request->Estatus;
        $casa->descripcion = $request->Descripcion;
        $casa->save(); // Guardar los cambios

        // Subir nuevas imágenes si existen
        if ($request->hasFile('nuevas_imagenes')) {
            foreach ($request->file('nuevas_imagenes') as $image) {
                // Guardar cada imagen en el almacenamiento público
                $path = $image->store('imagenes', 'public');

                // Crear una nueva instancia del modelo de imagen y asociarla con la propiedad
                $casa->imagenes()->create([
                    'path' => $path,
                ]);
            }
        }


        return redirect()->route('casas.editar', $id)->with('success', 'Casa actualizada correctamente.');
    }

    public function eliminar($id)
    {
        $casa = Propiedad::findOrFail($id); // Buscar la casa por su ID
        $casa->delete(); // Eliminar la casa de la base de datos

        return redirect()->route('home')->with('success', 'Casa eliminada correctamente.');
    }

    public function destroy($id)
    {
        $imagen = Imagen::findOrFail($id);

        if (Storage::delete($imagen->path)) {
            $imagen->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function detalles($id)
    {
        // Buscar la propiedad por su ID junto con sus imágenes
        $propiedad = Propiedad::with('imagenes')->findOrFail($id);

        // Retornar la vista 'detalles' pasando los datos de la propiedad
        return view('detalles', ['propiedad' => $propiedad]);
    }




    }


