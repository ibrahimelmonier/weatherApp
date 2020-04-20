<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Zttp\Zttp;

class WeatherController extends Controller
{
    public function getWeather()
    {
        $apiKey = config('services.weatherApi.key');
        $lat = \request('lat');
        $lon = \request('lon');

        $response = Zttp::get("api.openweathermap.org/data/2.5/onecall?lat=$lat&lon=$lon&units=metric&appid=$apiKey");

        return $response->json();
    }
}
