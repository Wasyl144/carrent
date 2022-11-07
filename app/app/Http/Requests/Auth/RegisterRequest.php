<?php

namespace App\Http\Requests\Auth;

use App\Http\DTO\Auth\LoginDTO;
use App\Http\DTO\Register\RegisterDTO;
use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required', 'string', 'max:64'],
            'last_name' => ['required', 'string', 'max:64'],
            'phone_number' => ['nullable', 'string', 'max:64'],
            'password' => ['required', 'min:6', 'string', 'confirmed'],
        ];
    }

    public function getDto(): RegisterDTO
    {
        return new RegisterDTO(
            name: $this->input('name'),
            lastName: $this->input('last_name'),
            password: $this->input('password'),
            email: $this->input('email'),
            phoneNumber: $this->input('phone_number'),
        );
    }
}
