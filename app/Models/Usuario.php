<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Authenticatable
{
    use Notifiable;

    // Nombre de la tabla en la base de datos
    // Lo ponemos explícito porque Laravel por defecto buscaría 'usuarios'
    protected $table='usuarios';

    protected $fillable = [ 
        'nombre',
        'correo',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'fecha_verificacion_correo' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
