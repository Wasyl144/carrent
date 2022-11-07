<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UserHasBeenActivatedException extends \Exception
{
    public function __construct(int $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        parent::__construct('User with assigned email has been activated before.', $code);
    }
}
