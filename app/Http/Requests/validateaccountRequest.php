<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class validateaccountRequest extends FormRequest
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
            'password' => 'required|string|min:8|same:password_confirmation',
            'password_confirmation' => 'required|string|min:8|same:password',
            // 'code' => 'required|numeric|exists:reset_passwords,code',
        ];
    }
    public function messages()
    {
        return [
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.same' => 'Les mots de passe ne correspondent pas.',
            'password_confirmation.required' => 'La confirmation du mot de passe est requise.',
            'password_confirmation.min' => 'La confirmation du mot de passe doit comporter au moins 8 caractères.',
            'password_confirmation.same' => 'Les mots de passe ne correspondent pas.',
            'code.required' => 'Le code est requis.',
            'code.numeric' => 'Le code doit être un nombre.',
            'code.exists' => 'Le code n\'existe pas ',

        ];
    }
}
