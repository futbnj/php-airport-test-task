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

    private string $fromTimezone;
    private string $toTimezone;

    public function __construct(
        Airport $fromAirport,
        string $fromTime,
        Airport $toAirport,
        string $toTime,
        string $fromDate,
        string $toDate,
        string $fromTimezone,
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
        $this->fromTimezone = $fromTimezone;
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
        return $this->calculateDateTimeDifference() + $this->calculateTimezoneDifference();
    }

    private function calculateDateTimeDifference(): int
    {
        $diffDateTime =
            $this->toDateTime($this->fromDate, $this->fromTime)->diff($this->toDateTime($this->toDate, $this->toTime));

        if ($diffDateTime->invert === 1) {
            return -1*($diffDateTime->d * 1440 + $diffDateTime->h * 60 + $diffDateTime->i);
        } else {
            return $diffDateTime->d * 1440 + $diffDateTime->h * 60 + $diffDateTime->i;
        }
    }

    private function calculateTimezoneDifference(): int
    {
        $diffTimezone =
            $this->formatTimezone($this->fromTimezone) - $this->formatTimezone($this->toTimezone);

        return $diffTimezone * 60;
    }

    private function formatTimezone(string $timezone): string
    {
        return preg_replace("/[^-+0-9]/", '', $timezone);
    }

    private function toDateTime(string $date, string $time): DateTime | string
    {
        try {
            return new DateTime($date . ' ' . $time);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}