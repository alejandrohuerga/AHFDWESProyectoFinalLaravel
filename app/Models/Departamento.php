<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    // Clase que representa un Departamento en la base de datos.

    use HasFactory;

    // Nombre exacto de la tabla.
    protected $table = '_t02_departamento';

    // Clave primari de la tabla.
    protected $primaryKey = 'CodDepartamento';

    // No es auto-incremental
    public $incrementing = false;

    // Tipo de clave primaria (string)
    protected $keyType = 'string';

    public $timestamps = false;

    // Campos que se pueden insertar masivamente
    protected $fillable = [
        'CodDepartamento',
        'DescDepartamento',
        'FechaCreacionDepartamento',
        'VolumenDeNegocio',
        'FechaBajaDepartamento',
    ];

}
