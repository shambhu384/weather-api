<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class CityNotFoundException extends ServiceUnavailableHttpException
{
    public function __construct(string $message) {
        parent::__construct(5, $message);
    }
}
