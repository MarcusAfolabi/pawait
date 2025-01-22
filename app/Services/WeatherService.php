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
        // Step 1: Fetch coordinates (lat & lon) using the current endpoint
        $currentWeatherResponse = Http::get("{$this->baseUrl}/weather", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => $units,
        ]);

        info($currentWeatherResponse->json());
        if ($currentWeatherResponse->failed()) {
            throw new \Exception('Failed to fetch weather data.');
        }

        $currentWeather = $currentWeatherResponse->json();
        $lat = $currentWeather['coord']['lat'];
        $lon = $currentWeather['coord']['lon'];

        // Step 2: Fetch 3-day forecast using the One Call API
        $forecastResponse = Http::get("https://api.openweathermap.org/data/3.0/onecall", [
            'lat' => $lat,
            'lon' => $lon,
            'exclude' => 'minutely,hourly,alerts',
            'appid' => $this->apiKey,
            'units' => $units,
        ]);

        if ($forecastResponse->failed()) {
            throw new \Exception('Failed to fetch weather forecast.');
        }

        $forecast = $forecastResponse->json()['daily'];

        // Return only the next 3 days
        $threeDayForecast = array_slice($forecast, 0, 3);

        return [
            'current' => $currentWeather,
            'forecast' => $threeDayForecast,
        ];
    }

}