<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array // este metodo es el que se encarga de transformar el recurso en un array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'is_active' => $this->is_active, // este es un booleano que indica si el usuario esta activo o no
            'created_at' => $this->created_at?->toIso8601String(), // este formato es para que se pueda serializar osea convertir a strin el objeto de fecha y hora
        ];
    }
}
