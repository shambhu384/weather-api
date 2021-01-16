<?php

namespace App\Dto\Weather;

class Location
{
    private string $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
