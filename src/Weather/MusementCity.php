<?php

namespace App\Weather;

use App\Exception\CityNotFoundException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Component\HttpClient\Exception\ServerException;

class MusementCity implements CityInterface
{
    private HttpClientInterface $musementClient;
    private string $httpClientCacheDir;

    public function __construct(HttpClientInterface $musementClient, string $httpClientCacheDir)
    {
        $this->musementClient = $musementClient;
        $this->httpClientCacheDir = $httpClientCacheDir;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll(): array
    {
        $store = new Store($this->httpClientCacheDir);
        $client = new CachingHttpClient($this->musementClient, $store, ['default_ttl' => 3600]);

        $response = $client->request('GET','https://api.musement.com/api/v3/cities');
        try {
            if ($response->getStatusCode() == Response::HTTP_OK) {
                return array_map(fn($city): string => $city['name'], json_decode($response->getContent(), true));
            }
        } catch (TransportException | ServerException | ClientExceptionInterface $e) {
            throw new CityNotFoundException('City service not available');
        }
    }
}
