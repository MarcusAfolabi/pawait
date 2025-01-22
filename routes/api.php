<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::prefix('v1')->group(function () {
    Route::get('/weather', [WeatherController::class, 'getWeather']);
});