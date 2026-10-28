<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo (opcional si sigue la convención en plural).
     */
    protected $table = 'contacts';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'email',
    ];

    /**
     * Relación: Un contacto pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
