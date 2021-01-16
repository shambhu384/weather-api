<?php

namespace App\Dto\Weather;

use App\Dto\Day;

class Forecast
{
    /**
     * @var ForecastDay[]
     */
    private array $forecastday = [];

    public function setForecastday($forecastday)
    {
        $this->forecastday = $forecastday;
    }

    public function getForecastdays(): array
    {
        $this->forecastday;
    }
}
