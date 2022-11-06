<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends \Exception
{
    public function __construct(int $code = Response::HTTP_NOT_FOUND)
    {
        parent::__construct('User not found', $code);
    }
}
