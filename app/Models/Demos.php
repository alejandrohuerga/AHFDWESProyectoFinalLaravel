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

}
