<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'surname' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => ['required', 'string', 'unique:users'],
            'email' => ['sometimes', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
        ];
    }
}
