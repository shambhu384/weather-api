<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Utils\TextFormatter;
use App\Dto\WeatherDto;

class TextFormatterTest extends TestCase
{
    public function testEmptyData()
    {
        $textFormatter = new TextFormatter();
        $outputText = $textFormatter->format(new \EmptyIterator());
        $this->assertEmpty($outputText);
    }

    public function testWithData()
    {
        $textFormatter = new TextFormatter();
        $outputText = $textFormatter->format(new \ArrayIterator([[
            new WeatherDto('Hartbeespoort', 'Partly cloudy'),
        ]]));
        $this->assertSame('Processed city Hartbeespoort | Partly cloudy', $outputText);
    }

    public function testWithMultipleData()
    {
        $textFormatter = new TextFormatter();
        $outputText = $textFormatter->format($this->dataProvider());
        $expected= 'Processed city Hartbeespoort | Partly cloudy
Processed city Salt Lake City | Partly cloudy';
        $this->assertSame($expected, $outputText);
    }

    public function dataProvider(): iterable
    {
        yield [
            new WeatherDto('Hartbeespoort', 'Partly cloudy'),
            new WeatherDto('Salt Lake City', 'Partly cloudy')
        ];
    }
}
