<?php

namespace App\Dtos;

use Symfony\Component\Validator\Constraints as Assert;

class GetCityWeatherRequest
{

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^[a-zA-Z0-9\-\_]+$/")
     */
    public string $countryCode;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^[a-zA-Z0-9\-\_]+$/")
     */
    public string $cityName;

}