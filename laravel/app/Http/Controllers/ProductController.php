<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function recommend(string $city): string
    {
        $city = strtolower(htmlspecialchars($city));
        $cachedResponse = Cache::get($city);
        if ($cachedResponse) return $cachedResponse;

        $response = (new Product)->recommendProductByWeather($city);
        return $response;
    }
}
