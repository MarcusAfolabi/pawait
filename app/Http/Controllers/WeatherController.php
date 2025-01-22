<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getWeather(Request $request)
    {
        // validate the incoming request
        $request->validate([
            'city' => 'required|string',
            'units' => 'in:metric,imperial',
        ]);

        try {
            $data = $this->weatherService->fetchWeather(
                $request->query('city'),
                $request->query('units', 'metric')
            );

            return response()->json(['status' => 'success', 'message' => 'weather found', 'data' => $data],200);
        } catch (\Exception $e) {
            // Log the error for debug purposes
            Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}