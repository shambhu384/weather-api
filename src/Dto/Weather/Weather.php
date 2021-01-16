<?php

namespace App\Dto\Weather;

class Weather
{
    private Location $location;

    private Forecast $forecast;

    public function __construct()
    {
        $this->location = new Location();
        $this->forecast = new Forecast();
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    public function getForecast()
    {
        return $this->forecast;
    }

    public function setForecast(Forecast $forecast)
    {
        $this->forecast = $forecast;
    }
}
