<?php

namespace App\Weather;

interface CityInterface
{
    /**
     * Get all cities
     *
     * @return string[]
     */
    public function getAll(): array;
}
