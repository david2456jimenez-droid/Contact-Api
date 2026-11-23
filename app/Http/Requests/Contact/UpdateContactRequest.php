<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
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
            'phone_number' => ['required', 'string', 'max:50', Rule::unique('contacts', 'phone_number')->ignore($this->route('contact'))],
            'email' => ['required', 'email', 'max:100', Rule::unique('contacts', 'email')->ignore($this->route('contact'))],
            'address' => ['required', 'string', 'max:100'],
        ];
    }
}
