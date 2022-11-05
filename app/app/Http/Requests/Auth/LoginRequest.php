<?php

namespace App\Http\Requests\Auth;

use App\Http\DTO\Auth\LoginDTO;
use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'string']
        ];
    }

    public function getDto(): LoginDTO
    {
        return new LoginDTO(
            email: $this->input('email'),
            password: $this->input('password')
        );
    }
}
