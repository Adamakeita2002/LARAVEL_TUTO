<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class configrequest extends FormRequest
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
            'type' => 'required|unique:configurations|string|max:255',
            'value' => 'required|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'type.unique' => 'Le type doit être unique.',
            'type.required' => 'Le type est requis.',
            'value.required' => 'La valeur est requise.',
            'value.string' => 'La valeur doit être une chaîne de caractères.',
            'value.max' => 'La valeur ne peut pas dépasser 255 caractères.',
        ];
    }
}
