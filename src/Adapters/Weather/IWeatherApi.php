<?php

namespace App\Adapters\Weather;

interface IWeatherApi
{

    /**
     * @return WeatherResultType[]
     */
    public function getCityWeather(string $countryName, string $cityName): ?array;

}