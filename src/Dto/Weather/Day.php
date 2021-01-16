<?php

namespace App\Dto\Weather;

class Day
{
    public array $condition = [];

    public function setCondition(array $condition)
    {
        $this->condition = $condition;
    }

    public function getCondition(): array
    {
        return $this->condition;
    }
}
