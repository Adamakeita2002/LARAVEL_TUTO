<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartementRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:departements,nom',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom du departement est requis.',
            'name.string' => 'Le nom du departement doit être une chaîne de caractères.',
            'name.max' => 'Le nom du departement ne doit pas dépasser 255 caractères.',
            'name.unique' => 'Le nom du departement doit être unique.',

        ];
    }
}
