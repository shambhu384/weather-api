<?php

namespace App\Dto\Weather;

class ForecastDay
{
    public array $day = [];

    public function setDay(array $day)
    {
        $this->day = $day;
    }

    public function getDay(): array
    {
        return $this->day;
    }
}

