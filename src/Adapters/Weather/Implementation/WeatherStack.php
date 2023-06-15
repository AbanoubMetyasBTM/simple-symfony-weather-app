<?php

namespace App\Adapters\Weather\Implementation;

use App\Adapters\Weather\IWeatherApi;
use App\Adapters\Weather\WeatherResultType;
use App\Helpers\SiteLogger;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherStack implements IWeatherApi
{

    private                     $baseUrl = "http://api.weatherapi.com/v1";
    private HttpClientInterface $httpClient;
    private SiteLogger          $logger;

    public function __construct(
        HttpClientInterface $client,
        SiteLogger          $logger
    )
    {
        $this->httpClient = $client;
        $this->logger     = $logger;
    }

    /**
     * @return WeatherResultType[]
     */
    private function transformResponseToResultObject(array $current,array $days): array
    {

        $returnedArr = [];

        foreach ($days as $day) {
            $weatherResObj = new WeatherResultType();

            $weatherResObj
                ->setDate($day["date"])
                ->setCurDegree($current["temp_c"])
                ->setMinDegree($day["day"]["mintemp_c"])
                ->setMaxDegree($day["day"]["maxtemp_c"])
                ->setWindMaxSpeed($day["day"]["maxwind_kph"])
                ->setAvgHumidity($day["day"]["avghumidity"])
                ->setDailyChanceOfRain($day["day"]["daily_chance_of_rain"])
                ->setDailyChanceOfSnow($day["day"]["daily_chance_of_snow"])
                ->setConditionText($day["day"]["condition"]["text"])
                ->setConditionIcon($day["day"]["condition"]["icon"]);

            $returnedArr[] = $weatherResObj;
        }

        return $returnedArr;

    }

    /**
     * @return WeatherResultType[]
     */
    public function getCityWeather(string $countryName, string $cityName): ?array
    {

        try {

            $httpParams = [
                "key"    => getenv("WEATHER_API_KEY"),
                "q"      => $cityName . "," . $countryName,
                "days"   => 3,
                "aqi"    => "no",
                "alerts" => "no",
            ];

            $response = $this->httpClient->request(
                'GET',
                $this->baseUrl . "/forecast.json?" . http_build_query($httpParams)
            );

            $content = $response->toArray();

            if ($response->getStatusCode() != 200) {
                $this->logger->logError("weatherstack api wrong status code");
                throw new HttpException(322, "invalid weather api response");
            }

            return $this->transformResponseToResultObject(
                $content["current"],
                $content["forecast"]["forecastday"]
            );

        } catch (\Throwable $exception) {
            $this->logger->logError("weatherstack api error ", $exception);

            throw new HttpException(322, "invalid weather api response");
        }

    }


}