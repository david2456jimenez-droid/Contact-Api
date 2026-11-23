<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

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
        'address',
        'avatar_url',
    ];

    /**
     * Relación: Un contacto pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function defaultAvatar(): string
    {
        $colors = ['#0B7A85', '#8A5200', '#1F6E45', '#A23628', '#5B4B9A', '#2F5D8C'];
        $color = $colors[$this->id % count($colors)];
        $letter = mb_strtoupper(mb_substr($this->first_name, 0, 1));

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="96" height="96">'
            .'<circle cx="48" cy="48" r="48" fill="'.$color.'"/>'
            .'<text x="48" y="62" font-size="44" font-family="Arial" fill="#fff" text-anchor="middle">'.$letter.'</text>'
            .'</svg>';

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }
}
