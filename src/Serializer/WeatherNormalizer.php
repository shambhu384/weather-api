<?php

namespace App\Serializer;

use App\Dto\WeatherDto;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;

class WeatherNormalizer implements ContextAwareDenormalizerInterface
{
    public function denormalize($data, $type, $format = null, $context = [])
    {
        $weatherDtos = [];

        foreach($data['forecast']['forecastday'] as $index =>$forecastday) {
            $weatherDtos[] = new WeatherDto(
                $data['location']['name'],
                $forecastday['day']['condition']['text']
            );
        }
        return $weatherDtos;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = [])
    {
        return $type === sprintf('%s[]', WeatherDto::class);
    }
}
