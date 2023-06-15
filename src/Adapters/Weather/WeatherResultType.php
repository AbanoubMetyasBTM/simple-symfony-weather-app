<?php

namespace App\Adapters\Weather;

class WeatherResultType
{

    private string $date;
    private float  $curDegree;
    private float  $minDegree;
    private float  $maxDegree;
    private float  $windMaxSpeed;
    private float  $avgHumidity;
    private int    $dailyChanceOfRain;
    private int    $dailyChanceOfSnow;
    private string $conditionText;
    private string $conditionIcon;

    /**
     * @param string $date
     */
    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param float $minDegree
     */
    public function setMinDegree(float $minDegree): self
    {
        $this->minDegree = $minDegree;
        return $this;
    }

    /**
     * @param float $curDegree
     */
    public function setCurDegree(float $curDegree): self
    {
        $this->curDegree = $curDegree;
        return $this;
    }

    /**
     * @param float $maxDegree
     */
    public function setMaxDegree(float $maxDegree): self
    {
        $this->maxDegree = $maxDegree;
        return $this;
    }

    /**
     * @param float $windMaxSpeed
     */
    public function setWindMaxSpeed(float $windMaxSpeed): self
    {
        $this->windMaxSpeed = $windMaxSpeed;
        return $this;
    }

    /**
     * @param float $avgHumidity
     */
    public function setAvgHumidity(float $avgHumidity): self
    {
        $this->avgHumidity = $avgHumidity;
        return $this;
    }

    /**
     * @param int $dailyChanceOfRain
     */
    public function setDailyChanceOfRain(int $dailyChanceOfRain): self
    {
        $this->dailyChanceOfRain = $dailyChanceOfRain;
        return $this;
    }

    /**
     * @param int $dailyChanceOfSnow
     */
    public function setDailyChanceOfSnow(int $dailyChanceOfSnow): self
    {
        $this->dailyChanceOfSnow = $dailyChanceOfSnow;
        return $this;
    }

    /**
     * @param string $conditionText
     */
    public function setConditionText(string $conditionText): self
    {
        $this->conditionText = $conditionText;
        return $this;
    }

    /**
     * @param string $conditionIcon
     */
    public function setConditionIcon(string $conditionIcon): self
    {
        $this->conditionIcon = $conditionIcon;
        return $this;
    }


    /**
     * @return float
     */
    public function getMinDegree(): float
    {
        return $this->minDegree;
    }
    /**
     * @return float
     */
    public function getCurDegree(): float
    {
        return $this->curDegree;
    }

    /**
     * @return float
     */
    public function getMaxDegree(): float
    {
        return $this->maxDegree;
    }

    /**
     * @return float
     */
    public function getWindMaxSpeed(): float
    {
        return $this->windMaxSpeed;
    }

    /**
     * @return float
     */
    public function getAvgHumidity(): float
    {
        return $this->avgHumidity;
    }

    /**
     * @return int
     */
    public function getDailyChanceOfRain(): int
    {
        return $this->dailyChanceOfRain;
    }

    /**
     * @return int
     */
    public function getDailyChanceOfSnow(): int
    {
        return $this->dailyChanceOfSnow;
    }

    /**
     * @return string
     */
    public function getConditionText(): string
    {
        return $this->conditionText;
    }

    /**
     * @return string
     */
    public function getConditionIcon(): string
    {
        return $this->conditionIcon;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }


}