<?php

namespace App\Tests\Unit;

use App\Entity\WeatherDay;
use App\Repository\WeatherDayRepository;

class WeatherDayUnitTest extends BaseUnit
{

    public function testCreatedRow(): void
    {
        /**
         * @var $weatherDayRepository WeatherDayRepository
         */
        $weatherDayRepository = $this->em->getRepository(WeatherDay::class);

        $returnedObj = $weatherDayRepository->createNewRow("EG", "Cairo", []);

        $this->assertTrue($returnedObj->getId() > 0);
    }

    public function testGetRow(): void
    {
        /**
         * @var $weatherDayRepository WeatherDayRepository
         */
        $weatherDayRepository = $this->em->getRepository(WeatherDay::class);

        $weatherDayRepository->createNewRow("EG", "Cairo", []);
        $returnedObj = $weatherDayRepository->findCityWeatherForaCertainDay("EG", "Cairo", date("Y-m-d H"));

        $this->assertTrue($returnedObj != null);
    }


}
