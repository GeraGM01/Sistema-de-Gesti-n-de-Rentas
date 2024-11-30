<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'propiedad';

    // Llave primaria de la tabla
    protected $primaryKey = 'id';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'ID_Usuario',
        'Direccion',
        'Estado',
        'Municipio',
        'Calificacion',
        'Reseñas',
        'Precio_Renta',
        'Descripcion',
        'Tipo',
        'Estatus',
    ];

    // Si no usas timestamps (opcional, eliminar si los usas)
    public $timestamps = true;

    // Relaciones posibles (opcional, ajusta según tus necesidades)

    /**
     * Relación con el usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'ID_Usuario');
    }

    /**
     * Relación con imágenes (si hay tabla de imágenes relacionadas).
     */
    public function imagenes()
    {
        return $this->hasMany(imagen::class, 'propiedad_id');
    }
}
