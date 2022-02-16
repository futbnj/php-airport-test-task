<?php

namespace App\Entity;

use DateTime;

class Flight
{
    private Airport $fromAirport;
    private string $fromTime;
    private string $fromDate;
    private Airport $toAirport;
    private string $toTime;
    private string $toDate;

    private string $fromTimeZone;
    private string $toTimezone;

    public function __construct(
        Airport $fromAirport,
        string $fromTime,
        Airport $toAirport,
        string $toTime,
        string $fromDate,
        string $toDate,
        string $fromTimeZone,
        string $toTimezone
    )
    {
        $this->fromAirport = $fromAirport;
        $this->fromTime = $fromTime;
        $this->fromDate = $fromDate;
        $this->toAirport = $toAirport;
        $this->toTime = $toTime;
        $this->toDate = $toDate;
        $this->toTimezone = $toTimezone;
        $this->fromTimeZone = $fromTimeZone;
    }

    public function getFromAirport(): Airport
    {
        return $this->fromAirport;
    }

    public function getFromTime(): string
    {
        return $this->fromTime;
    }

    public function getFromDate(): string
    {
        return $this->fromDate;
    }

    public function getToAirport(): Airport
    {
        return $this->toAirport;
    }

    public function getToTime(): string
    {
        return $this->toTime;
    }

    public function getToDate(): string
    {
        return $this->toDate;
    }

    public function getFromTimeZone(): string
    {
        return $this->fromTimeZone;
    }

    public function getToTimeZone(): string
    {
        return $this->toTimezone;
    }

    public function calculateDurationMinutes(): int
    {
        return $this->calculateMinutesFromStartDay($this->fromDate . ' ' . $this->fromTime, $this->toDate . ' ' . $this->toTime);
    }

    private function calculateMinutesFromStartDay(string $fromTime, string $toTime): int
    {
        $fromTime = new DateTime($fromTime);
        $toTime = new DateTime($toTime);
        $differenceObj = $fromTime->diff($toTime);
        $differenceTimezone = (int) preg_replace("/[^-+0-9]/", '', $this->fromTimeZone) - (int) preg_replace("/[^-+0-9]/", '', $this->toTimezone);

        if ($differenceObj->invert === 1) {
            return -1*($differenceObj->d * 1440 + $differenceObj->h * 60 + $differenceObj->i) + ($differenceTimezone * 60);
        } else {
            return $differenceObj->d * 1440 + $differenceObj->h * 60 + $differenceObj->i + ($differenceTimezone * 60);
        }

    }
}