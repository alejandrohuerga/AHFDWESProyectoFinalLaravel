<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase que representa la demos al ingresarla en la aplicación.
 * 
 * 
 * @author Alejandro De la Huerga Fernández
 * @since 16/03/2026
 */

class Demos extends Model
{
    /** 
     * Nombre de la tabla en la base de datos
     * Lo ponemos explícito porque Laravel por defecto buscaría 'demos'. 
     *
     * @var String
    */
    protected $table = 'demos';

    // Indicamos el nombre de las columnas de la tabla que se corresponden con las fechas de creación y actualización.
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_subida';

    /**
     * Campos que se pueden asignar de forma masiva.
     * Esto es importante para proteger contra asignación masiva no deseada.
     *
     * @var array
     */

    protected $fillable = [
        'usuario_id',
        'nombre_archivo',
        'nombre_original',
        'ruta',
        'estado',
        'fecha_subida',
        'fecha_creacion'
    ];

}
