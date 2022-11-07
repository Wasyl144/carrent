<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class TokenNotFoundException extends \Exception
{
    public function __construct(int $code = Response::HTTP_NOT_FOUND)
    {
        parent::__construct('Token is not found or Will be expired.', $code);
    }
}
