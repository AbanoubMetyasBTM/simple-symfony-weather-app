<?php

namespace App\Entity;

use App\Repository\WeatherDayRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeatherDayRepository::class)
 */
class WeatherDay
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cityName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $dayKey;

    /**
     * @ORM\Column(type="text")
     */
    private $forecastDays;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): self
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getDayKey(): ?string
    {
        return $this->dayKey;
    }

    public function setDayKey(string $dayKey): self
    {
        $this->dayKey = $dayKey;

        return $this;
    }

    public function getForecastDays(): ?array
    {
        return json_decode($this->forecastDays);
    }

    public function setForecastDays(string $forecastDays): self
    {
        $this->forecastDays = $forecastDays;

        return $this;
    }
}
