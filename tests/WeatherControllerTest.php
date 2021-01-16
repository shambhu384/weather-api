<?php

namespace App\Tests;

use App\Controller\WeatherController;
use App\Weather\CityInterface;
use App\Weather\WeatherInterface;
use App\Weather\WeatherApi;
use App\Utils\TextFormatter;
use App\Exception\CityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class WeatherControllerTest extends KernelTestCase
{
    private WeatherController $controller;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->controller = new WeatherController();
    }

    public function testControllerExpectInterServerError()
    {
        $city = new class implements CityInterface {
            public function getAll(): array
            {
                throw new CityNotFoundException('City not available');
            }
        };

        $weatherApi = new WeatherApi(
            $city,
            static::$container->get(HttpClientInterface::class),
            static::$container->get(SerializerInterface::class)
        );

        $this->expectException(CityNotFoundException::class);

        $response = $this->controller->get(
            $weatherApi,
            new TextFormatter()
        );
        $this->assertEquals(Response::HTTP_SERVICE_UNAVAILABLE, $response->getStatusCode());
    }

    public function testControllerGetSuccess()
    {
        $city = new class implements CityInterface {
            public function getAll(): array
            {
                return ['Paris'];
            }
        };

        $weatherMockResponse =  new MockHttpClient( function ($method, $url, $options) {
            return new MockResponse(json_encode([
                'location' => ['name' => 'Paris'],
                'forecast' => [
                    'forecastday' => [
                        ['day' => ['condition' => ['text' => 'Moderate or heavy snow showers']]],
                        ['day' => ['condition' => ['text' => 'Patchy rain possible']]]
                    ]
                ]
            ]));
        }, 'https://example.com');

        $weatherApi = new WeatherApi(
            $city,
            $weatherMockResponse,
            static::$container->get(SerializerInterface::class)
        );

        $response = $this->controller->get(
            $weatherApi,
            new TextFormatter()
        );
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $expected= 'Processed city Paris | Moderate or heavy snow showers
Processed city Paris | Patchy rain possible';
        $this->assertEquals($expected, $response->getContent()); 
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
