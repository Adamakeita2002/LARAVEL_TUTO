<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HandleRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|',

        ];
    }
    public function messages()
    {
        return [
            "name.required" => 'Le champ non est requise',
            'name.string' => 'Le champ nom doit etre en chaine de caractere',
            'email.email' => 'Le champ email doit etre de type email ',
            'email.required' => 'Le champ email est requis',
            'email.unique' => 'Cet utilisateur existe deja',
            'password.required' => ' Le champ mot de passe est requis',
            'password.min:8' => 'le champ password doit comporte au moins 8 chiffres'
        ];
    }
}
