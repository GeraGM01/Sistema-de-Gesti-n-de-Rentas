<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imagen extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'images';

    // Llave primaria de la tabla
    protected $primaryKey = 'id';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'propiedad_id',
        'path',
    ];

    // Si no usas timestamps (opcional, eliminar si los usas)
    public $timestamps = true;

    /**
     * Relación con la propiedad.
     */
    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class, 'propiedad_id');
    }
}
