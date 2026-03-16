<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Usuario (Representa un Usuario de la Base de Datos).
 * 
 * Extiende de la clase Authenticatable lo cual nos permite decirle a Laravel
 * que esta clase puede iniciar session , registrarse ...
 * 
 * @author Alejandro De la huerga.
 * @since 16/03/2026
 * @version 1.0.0
 */

class Usuario extends Authenticatable
{
    //
}
