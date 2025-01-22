<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.openweather.base_url');
        $this->apiKey = config('services.openweather.key');
    }

    public function fetchWeather(string $city, string $units = 'metric')
    {
        $response = Http::get("{$this->baseUrl}weather", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => $units,
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch weather data.');
        }

        return $response->json();
    }
}