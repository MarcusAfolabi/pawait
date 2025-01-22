<?php

namespace Tests\Unit;

use App\Services\WeatherService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class WeatherServiceTest extends TestCase
{
    #[Test]
    public function it_fetches_weather_data_successfully()
    {
        // Mock the HTTP response
        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'weather' => [
                    ['description' => 'clear sky', 'icon' => '01d']
                ],
                'main' => ['temp' => 25.5, 'humidity' => 60],
                'wind' => ['speed' => 5.5],
                'name' => 'Nairobi',
            ], 200),
        ]);

        $service = new WeatherService();
        $data = $service->fetchWeather('Nairobi', 'metric');

        $this->assertArrayHasKey('weather', $data);
        $this->assertEquals('Nairobi', $data['name']);
        $this->assertEquals(25.5, $data['main']['temp']);
    }

    #[Test]
    public function it_handles_failed_weather_data_fetch()
    {
        Http::fake([
            'api.openweathermap.org/*' => Http::response([], 404),
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to fetch weather data.');

        $service = new WeatherService();
        $service->fetchWeather('InvalidCity', 'metric');
    }
}