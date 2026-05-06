<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    protected $table = 'jugadores';

    

    protected $fillable = [
        'nombreJugador',
        'nombreEquipo',
        'bajas_totales',
        'headshot_porcentaje',
        'muertes_totales',
        'KD_ratio',
        'damage_por_ronda',
        'mapas_jugados',
        'bajas_por_ronda',
        'asistencias_por_ronda',
        'muertes_por_ronda',
        'rating_de_impacto'
    ];
}
