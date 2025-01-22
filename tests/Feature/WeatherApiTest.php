<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class WeatherApiTest extends TestCase
{
    #[Test]
    public function it_returns_weather_data_for_a_valid_city()
    {
        $response = $this->getJson('/api/v1/weather?city=Nairobi&units=metric');

        info($response->json());
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'coord' => ['lon', 'lat'],
                    'weather' => [['id', 'main', 'description', 'icon']],
                    'main' => ['temp', 'humidity'],
                    'wind' => ['speed', 'deg', 'gust'],
                    'name',
                ],
            ]);
    }

    #[Test]
    public function it_returns_error_for_missing_city_parameter()
    {
        $response = $this->getJson('/api/v1/weather');

        $response->assertStatus(422) // Validation error
            ->assertJsonValidationErrors(['city']);
    }

    #[Test]
    public function it_returns_error_for_invalid_city()
    {
        $response = $this->getJson('/api/v1/weather?city=InvalidCity&units=metric');

        $response->assertStatus(500)
            ->assertJson([
                'status' => 'error',
                'message' => 'Failed to fetch weather data.',
            ]);
    }
}