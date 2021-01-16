<?php

namespace App\Dto;

class WeatherDto
{
    private $locationName;

    private $forecastDay;

    public function __construct(string $locationName, string $forecastDay)
    {
        $this->locationName = $locationName;
        $this->forecastDay = $forecastDay;
    }

    public function getLocationName(): string
    {
        return $this->locationName;
    }

    public function getForecastDay(): string
    {
        return $this->forecastDay;
    }
}
