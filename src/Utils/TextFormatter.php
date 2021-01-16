<?php

namespace App\Utils;

class TextFormatter
{
    public function format(iterable $data): string
    {
        $outputText = "";

        foreach($data as $item) {
            foreach($item as $weatherDto) {
                if ($outputText == "") {
                    $outputText = sprintf(
                        "Processed city %s | %s",
                        $weatherDto->getLocationName(),
                        $weatherDto->getForecastDay(),
                    );
                    continue;
                }
                $outputText = $outputText . sprintf(
                    "\nProcessed city %s | %s",
                    $weatherDto->getLocationName(),
                    $weatherDto->getForecastDay()
                );
            }
        }

        return $outputText;
    }
}
