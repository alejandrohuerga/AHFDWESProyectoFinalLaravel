<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * Definimos la relación inversa de muchos a uno entre Comment y User.
     * Un comentario pertenece a un usuario, pero un usuario puede tener muchos comentarios.
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user(): BelongsTo 
    {
        // Un comentario pertenece a un usuario, por lo que usamos belongsTo. 
        // El primer parámetro es el modelo al que pertenece, el segundo es la clave foránea en la tabla comments, y el tercero es la clave local en la tabla users.
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
