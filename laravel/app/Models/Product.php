<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
 
class Product extends Model
{
    use HasFactory;

    public function recommendProductByWeather(string $city)
    {
        $url = 'https://api.meteo.lt/v1/places/' . $city . '/forecasts/long-term';
        $response = json_decode(Http::get($url), true);

        $forecasts = $this->getThreeDayForecast($response['forecastTimestamps']);
        $mostOccuringWeather = $this->getMostOccuringWeather($forecasts);

        return $mostOccuringWeather;
    }

    private function getThreeDayForecast(array $forecastTimestamps): array
    {
        $forecasts = [];
        $interval = [
            (date_create('tomorrow'))->format('Y-m-d'),
            (date_create('tomorrow + 1 day'))->format('Y-m-d'),
            (date_create('tomorrow + 2 days'))->format('Y-m-d')
        ];

        foreach ($forecastTimestamps as $forecast) {
            $dateAndTime = explode(' ', $forecast['forecastTimeUtc']);
            $date = array_shift($dateAndTime);
            
            if (!in_array($date, $interval)) continue;
            $condition = $forecast['conditionCode'];

            $forecasts[$date][$condition] = $forecasts[$date][$condition] ?? 0;
            $forecasts[$date][$condition] += 1;

            // if (isset($forecasts[$date][$condition])) {
            //     $forecasts[$date][$condition]++;
            // } else {
            //     $forecasts[$date][$condition] = 1;
            // }
        }

        return $forecasts;
    }

    private function getMostOccuringWeather(array $forecasts): array
    {
        $result = [];
        foreach ($forecasts as $date => $conditions) {
            $mostOccuringType = '';
            $occurence = 0;
            foreach($conditions as $condition => $count) {
                if ($count > $occurence) {
                    $mostOccuringType = $condition;
                    $occurence = $count;
                }
            }
            $result[$date] = $mostOccuringType;
        }

        return $result;
    }
}
