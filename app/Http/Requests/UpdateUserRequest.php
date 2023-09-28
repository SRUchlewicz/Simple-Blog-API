<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|between:3,15',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
