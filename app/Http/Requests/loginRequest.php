<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class loginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|uniques:users',
            'password' => 'required|min:8'
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'email est requis',
            'email.string' => 'email doit etre en chaine de caractere',
            'email.uniques' => 'email doit etre unique',
            'password.required' => 'password est requis',
            'password.min' => 'password doit etre au moins 8 chiffres'

        ];
    }
}
