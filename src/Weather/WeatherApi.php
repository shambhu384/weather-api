<?php

namespace App\Weather;

use App\Dto\WeatherDto;
use App\Exception\CityNotFoundException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\Exception\ClientException;

class WeatherApi implements WeatherInterface
{
    private CityInterface $city;
    private HttpClientInterface $weatherClient;
    private SerializerInterface $weatherSerializer;


    public function __construct(CityInterface $city, HttpClientInterface $weatherClient, SerializerInterface $weatherSerializer) {
        $this->city = $city;
        $this->weatherClient = $weatherClient;
        $this->weatherSerializer = $weatherSerializer;
    }

    /**
     * {@inhertDoc}
     */
    public function getForecasts(): iterable
    {
        $cities = $this->city->getAll();

        foreach ($cities as $city) {
            $responses[] = $this->weatherClient->request('GET','/v1/forecast.json', [
                'query' => [
                    'q' => $city,
                ]
            ]);
        }
        // TODO Cache response as weather is not changes for today
        foreach ($this->weatherClient->stream($responses) as $response => $chunk) {
            try {
                if (Response::HTTP_OK !== $response->getStatusCode()) {
                    $response->cancel();
                    continue;
                }
                if ($chunk->isLast()) {
                    yield $this->weatherSerializer->deserialize($response->getContent(), sprintf('%s[]', WeatherDto::class), 'json');
                }
            } catch (ClientException $clientException) {
            }
        }
    }
}
