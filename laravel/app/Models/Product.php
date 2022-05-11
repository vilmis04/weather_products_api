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
        $uri = 'https://api.meteo.lt/v1/places/' . $city . '/forecasts/long-term';
        $response = Http::get($uri);
        return $response;
    }
}
