<?php

namespace App\Services;

use App\Adapters\Weather\IWeatherApi;
use App\Entity\WeatherDay;
use App\Repository\WeatherDayRepository;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\Response;

class HomeService
{

    private AdapterInterface     $cache;
    private WeatherDayRepository $weatherDayRepository;
    private IWeatherApi          $weatherApi;

    public function __construct(
        AdapterInterface     $cache,
        WeatherDayRepository $weatherDayRepository,
        IWeatherApi          $weatherApi
    )
    {
        $this->cache                = $cache;
        $this->weatherDayRepository = $weatherDayRepository;
        $this->weatherApi           = $weatherApi;
    }


    public function getWeatherData($countryName, $cityName): ?WeatherDay
    {
        $currentDate = date("Y-m-d H");

        //check data from cache
        $cachedData = $this->cache->getItem("${countryName}-${cityName}-" . $currentDate);

        if ($cachedData->isHit()) {
            return $cachedData->get();
        }

        //check data from database
        $weatherObj = $this->weatherDayRepository->findCityWeatherForaCertainDay($countryName, $cityName, $currentDate);
        if (is_object($weatherObj)) {
            $cachedData->set($weatherObj);
            $this->cache->save($cachedData);
            return $weatherObj;
        }

        //get data from api, then store it at db and cache it
        $days = $this->weatherApi->getCityWeather($countryName, $cityName);
        if ($days == null) {
            throw new \HttpException("try again later", Response::HTTP_NOT_ACCEPTABLE);
        }

        $weatherObj = $this->weatherDayRepository->createNewRow($countryName, $cityName, $days);
        $cachedData->set($weatherObj);
        $this->cache->save($cachedData);

        return $weatherObj;
    }


}