<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Adminrequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:users,email,',
            'oldpassword' => 'required|string|min:8|same:password',
            'newpassword' => 'required|string|min:8|same:oldpassword',
            // 'password' => 'required|string|min:8|',

            // Add other validation rules as needed
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom complet est requis.',
            'email.required' => 'L\'email est requis.',
            // 'password.required' => 'Le mot de passe est requis.',
            // Add other custom messages as needed
        ];
    }
}
