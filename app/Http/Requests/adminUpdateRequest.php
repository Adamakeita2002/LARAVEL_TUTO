<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class adminUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'newpassword' => 'nullable|string|min:8|',
            'oldpassword' => 'nullable|string|min:8|',


        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'newpassword.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'oldpassword.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'newpassword.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'oldpassword.string' => 'Le mot de passe doit être une chaîne de caractères.',

        ];
    }
}
