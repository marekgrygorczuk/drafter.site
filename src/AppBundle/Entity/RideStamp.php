<?php

namespace AppBundle\Entity;


class RideStamp
{
    // day of week as in ISO-8601
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 7;

    /**
     * @var int
     */
    private $dayOfWeek;
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $locationDescription;

    /**
     * @var float
     */
    public $gpsLon;
    /**
     * @var float
     */
    public $gpsLat;

    /**
     * @var int
     */
    public $distance;

    /**
     * @var string
     */
    public $gear;

    /**
     * @var int
     */
    public $rideClockHour;
    /**
     * @var int
     */
    public $rideClockMinute;
    /**
     * RideStamp constructor.
     */
    public function __construct()
    {
        $this->id = mt_rand();
    }

    /**
     * @param int $dayOfWeek
     * @return bool
     * @throws \Exception
     */
    public function setDayOfWeekOccurrence(int $dayOfWeek)
    {
        if (($dayOfWeek < 1) OR ($dayOfWeek > 7)) throw new \Exception('Invalid day of week. Should be in 1-7 range');
        $this->dayOfWeek = $dayOfWeek;
        return true;
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    public function doesItHappenOn(\DateTime $date)
    {
        return ($date->format('N') == $this->dayOfWeek);
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }

    /**
     * @param int $dayOfWeek
     */
    public function setDayOfWeek($dayOfWeek)
    {
        $this->dayOfWeek = $dayOfWeek;
    }
}