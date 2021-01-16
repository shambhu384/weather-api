<?php

namespace App\Controller;

use App\Weather\WeatherInterface;
use App\Utils\TextFormatter;
use App\Exception\CityNotFoundException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WeatherController
{
    /**
     * @Route("/weather")
     */
    public function get(WeatherInterface $weather, TextFormatter $textFormatter): Response
    {
        try {
            $forecasts = $weather->getForecasts();
        } catch (CityNotFoundException $exception) {
            throw new HttpException(
                Response::HTTP_SERVICE_UNAVAILABLE,
            );
        }

        return new Response(
            $textFormatter->format($forecasts),
            Response::HTTP_OK,
            ['content-type' => 'text/plain']
        );
    }
}
