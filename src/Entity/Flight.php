<?php

namespace App\Entity;

class Flight
{
    private Airport $fromAirport;
    private string $fromTime;
    private string $fromDate;
    private Airport $toAirport;
    private string $toTime;
    private string $toDate;

    public function __construct(Airport $fromAirport, string $fromTime, Airport $toAirport, string $toTime, string $fromDate, string$toDate)
    {
        $this->fromAirport = $fromAirport;
        $this->fromTime = $fromTime;
        $this->fromDate = $fromDate;
        $this->toAirport = $toAirport;
        $this->toTime = $toTime;
        $this->toDate = $toDate;
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

    public function calculateDurationMinutes(): int
    {
        return $this->calculateMinutesFromStartDay($this->toTime) - $this->calculateMinutesFromStartDay($this->fromTime);
    }

    private function calculateMinutesFromStartDay(string $time): int
    {
        [$hour, $minutes] = explode(':', $time, 2);

        return 60 * (int) $hour + (int) $minutes;
    }
}