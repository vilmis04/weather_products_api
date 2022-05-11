<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function recommend(string $city): string
    {
        $response = (new Product)->recommendProductByWeather($city);
        return $response;
    }
}
