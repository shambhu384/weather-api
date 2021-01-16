<?php

namespace App\Weather;

interface WeatherInterface
{
    /**
     * Get weather of the given cities
     *
     * @return iterable
     */
    public function getForecasts(): ?iterable;
}
