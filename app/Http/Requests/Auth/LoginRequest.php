<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['required', 'string', 'max:100'], // se utiliza required para que el campo sea obligatorio, string para que sea una cadena de texto y max:100 para que no supere los 100 caracteres
        ]; // utilizamos device_name para identificar el dispositivo desde el cual se esta haciendo la peticion, esto es util
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Este campo es obligatorio',
            'email.email' => 'El correo electronico no tiene un formato valido',
            'password.required' => 'Este campo es obligatorio',
            'device_name.required' => 'Este campo es obligatorio',
            'device_name.string' => 'El nombre del dispositivo debe ser una cadena de texto',
            'device_name.max' => 'El nombre del dispositivo no debe superar los 100 caracteres',
        ];
    }
}
