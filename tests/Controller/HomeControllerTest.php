<?php

namespace App\Tests\Controller;

use App\Adapters\Weather\IWeatherApi;
use App\Adapters\Weather\WeatherResultType;
use App\Entity\WeatherDay;
use App\Services\HomeService;

class HomeControllerTest extends BaseController
{
    private function mockWeatherAdapter()
    {

        $weatherResObj = new WeatherResultType();

        $weatherResObj
            ->setDate(date("Y-m-d"))
            ->setCurDegree(20)
            ->setMinDegree(20)
            ->setMaxDegree(40)
            ->setWindMaxSpeed(10)
            ->setAvgHumidity(10)
            ->setDailyChanceOfRain(0)
            ->setDailyChanceOfSnow(0)
            ->setConditionText("Sunny")
            ->setConditionIcon("");


        $weatherRepository = $this->createMock(IWeatherApi::class);
        $weatherRepository
            ->method('getCityWeather')
            ->willReturn([
                $weatherResObj,
                $weatherResObj,
            ]);

        $this->appContainer->set(IWeatherApi::class, $weatherRepository);
    }

    public function testHomePageIsRunning(): void
    {
        $this->mockWeatherAdapter();

        $crawler = $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testGetWeatherInvalidValidation(): void
    {

        $this->mockWeatherAdapter();
        $crawler = $this->client->request('POST', '/get-result', [
            "token" => $this->generateCsrf(),
        ]);

        $this->assertTrue(strpos($this->client->getResponse()->getContent(), "This value should not be blank") >= 0);
    }

    public function testGetWeatherInvalidValidation2(): void
    {
        $this->mockWeatherAdapter();
        $crawler = $this->client->request('POST', '/get-result', [
            "token"       => $this->generateCsrf(),
            "cityName"    => "@#",
            "countryCode" => "@#",
        ]);

        $this->assertTrue(strpos($this->client->getResponse()->getContent(), "This value is not valid") >= 0);
    }

    public function testGetWeatherEndpoint(): void
    {
        $this->mockWeatherAdapter();

        $crawler = $this->client->request('POST', '/get-result', [
            "token"       => $this->generateCsrf(),
            "countryCode" => "EG",
            "cityName"    => "Giza",
        ]);

        $this->assertTrue($this->client->getResponse()->getStatusCode() == 200);
    }

    public function testGetWeatherService(): void
    {
        $this->mockWeatherAdapter();

        /**
         * @var $homeService HomeService
         */
        $homeService = $this->appContainer->get(HomeService::class);

        /**
         * @var $data WeatherDay
         */
        $data        = $homeService->getWeatherData("EG", "Giza");
        $forcastDays = $data->getForecastDays();

        $this->assertTrue(is_object($data));
        $this->assertTrue(count($forcastDays) > 0);
    }

}
