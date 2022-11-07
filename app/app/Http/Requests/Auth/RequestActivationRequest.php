<?php

namespace App\Http\Requests\Auth;

use App\Http\DTO\Activation\RequestForActivationDTO;
use App\Http\Requests\BaseRequest;

class RequestActivationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'exists:users,email'],
        ];
    }

    public function getDto(): RequestForActivationDTO
    {
        return new RequestForActivationDTO(
            email: $this->input('email')
        );
    }
}
