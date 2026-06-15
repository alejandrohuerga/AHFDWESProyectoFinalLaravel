<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * La clases Analisis representa el archivo JSON una vez realizada la 
 * explotación de estadisticas del archivo .dem 
 * Lo que se pretende con este modelo es el muestreo de los analisis sin necesidad
 * de almacenar los archivos .dem que son bastante mas pesados. 
 * 
 * @author Alejandro De la Huerga
 * @since 29/04/2026
 */

class Analisis extends Model
{
    /**
     * Utilizamos el casting de Eloquent.
     * Nos permitira convertir el archivo JSON en una cadena de texto cada vez que usemos
     * una tupla de base de datos y asi poder mostrarla comodamente en la vista.
     */
    
    protected $fillable = [
        'user_id',
        'map_name',
        'stats',
    ];

    protected $casts = [
        'stats' => 'array',
    ];
}
