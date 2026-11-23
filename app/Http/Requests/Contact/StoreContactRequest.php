<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:45'],
            'last_name' => ['nullable', 'string', 'max:45'],
            'phone_number' => ['required', 'string', 'max:50', 'unique:contacts,phone_number'],
            'email' => ['required', 'email', 'max:100', 'unique:contacts,email'],
            'address' => ['required', 'string', 'max:100'],
        ];
    }
}
