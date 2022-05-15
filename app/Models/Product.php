<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
 
class Product extends Model
{
    use HasFactory;

    public function recommendProductByWeather(string $city): string
    {
        $response = [
            'source' => 'LHMT',
            'city' => $city,
            'recommendations' => []
        ];

        $url = 'https://api.meteo.lt/v1/places/' . $city . '/forecasts/long-term';
        $apiResponse = json_decode(Http::get($url), true);

        $forecasts = $this->getThreeDayForecast($apiResponse['forecastTimestamps']);
        $response['recommendations'] = $this->getProductRecommendations($forecasts);

        $jsonResponse = json_encode($response, JSON_PRETTY_PRINT);
        Cache::put($city, $jsonResponse, now()->addMinutes(5));

        return $jsonResponse;
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
            $forecasts[$date][$condition]++;
        }

        $mostOccurinigType = $this->getMostOccuringWeather($forecasts);

        return $mostOccurinigType;
    }

    private function getMostOccuringWeather(array $forecasts): array
    {
        $result = [];
        foreach ($forecasts as $date => $conditions) {
            $weatherType = $this->calculateMostOccuringType($date, $conditions);
            $result[] = $weatherType;
        }

        return $result;
    }
    
    private function calculateMostOccuringType(string $date, array $conditions): array
    {
        $mostOccuringType = '';
        $occurence = 0;
        foreach($conditions as $condition => $count) {
            if ($count > $occurence) {
                $mostOccuringType = $condition;
                $occurence = $count;
            }
        }

        return [
            'weather_forecast' => $mostOccuringType,
            'date' => $date
        ];
    }

    private function getProductRecommendations(array $recommendations): array
    {   
        $numberOfProducts = 2;
        $result = [];
        foreach($recommendations as $condition) {
            $products = self::where('condition_1', $condition['weather_forecast'])
                ->take($numberOfProducts)
                ->get()
                ->toArray();

            $condition['products'] = $this->formatProductInfo($products);
            $result[] = $condition;
        }
        
        return $result;
    }

    private function formatProductInfo(array $products): array
    {
        $formatedProducts = [];
        if (count($products) === 0) return [['error' => 'No products for this weather type']];

        foreach($products as $product) {
            $formatedProducts[] = [
                'sku' => $product['sku'],
                'name' => $product['name'],
                'price' => $product['price']
            ];
        }

        return $formatedProducts;
    }
}