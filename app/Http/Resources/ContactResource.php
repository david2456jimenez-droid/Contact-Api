<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => $this->address,
            'avatar_url' => $this->avatar_url ?? $this->defaultAvatar(),
            'created_at' => $this->created_at?->toIso8601String(), // este formato es para que se pueda serializar osea convertir a string el objeto de fecha y hora
        ];
    }
}
