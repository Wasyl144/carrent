<?php

namespace App\Http\Requests\Auth;

use App\Http\DTO\Auth\ActivateDTO;
use App\Http\DTO\Auth\LoginDTO;
use App\Http\DTO\Register\RegisterDTO;
use App\Http\Requests\BaseRequest;

class ActivateAccountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'token' => ['required', 'string', 'exists:email_verification,token'],
        ];
    }

    public function getDto(): ActivateDTO
    {
        return new ActivateDTO(
            token: $this->query('token')
        );
    }
}
