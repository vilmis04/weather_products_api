<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // public function recommend(string $city): string
    public function recommend(string $city)
    {
        $city = strtolower(htmlspecialchars($city));
        $cachedResponse = cache($city);
        if ($cachedResponse) return $cachedResponse;
        
        $response = (new Product)->recommendProductByWeather($city);
        return $response;
    }
}
