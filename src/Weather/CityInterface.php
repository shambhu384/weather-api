<?php

namespace App\Weather;

interface CityInterface
{
    /**
     * Get all cities
     *
     * @return string[]
     * @thows CityNotFoundException
     */
    public function getAll(): array;
}
