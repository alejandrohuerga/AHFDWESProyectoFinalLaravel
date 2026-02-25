<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Definimos la relación de uno a muchos entre User y Comment. 
     * Un usuario puede tener muchos comentarios, pero un comentario solo pertenece a un usuario.
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function comments(): HasMany
    {
        // Se puede obviar el segundo y tercer parámetro si se siguen las convenciones de Laravel, pero los incluimos para mayor claridad.
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    
}
