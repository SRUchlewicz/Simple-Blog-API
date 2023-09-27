<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|between:3,15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8'
        ];
    }
}
