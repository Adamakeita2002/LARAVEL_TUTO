<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployerRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employers,email',
            'phone' => 'required|string|max:20|unique:employers,telephone',
            'departement' => 'required|exists:departements,id',
            'montant' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Le nom de l\'employé est requis.',
            'name.string' => 'Le nom de l\'employé doit être une chaîne de caractères.',
            'name.max' => 'Le nom de l\'employé ne doit pas dépasser 255 caractères.',
            'firstname.required' => 'Le prénom de l\'employé est requis.',
            'firstname.string' => 'Le prénom de l\'employé doit être une chaîne de caractères.',
            'firstname.max' => 'Le prénom de l\'employé ne doit pas dépasser 255 caractères.',

            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'email.max' => 'L\'adresse e-mail ne doit pas dépasser 255 caractères.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'phone.required' => 'Le numéro de téléphone est requis.',
            'phone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'phone.max' => 'Le numéro de téléphone ne doit pas dépasser 15 caractères.',
            'phone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'departement.required' => 'Le département est requis.',
            'montant.required' => 'Le montant est requis.',
            'montant.numeric' => 'Le montant doit être un nombre valide.',
            'departement.exists' => 'Le département sélectionné n\'existe pas.',
        ];
    }
}
