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
     * @param int $dayOfWeek
     * @return bool
     * @throws \Exception
     */
    public function setDayOfWeekOccurrence(int $dayOfWeek)
    {
        if (($dayOfWeek < 0) OR ($dayOfWeek > 7)) throw new \Exception('Invalid day of week. Should be in 1-7 range');
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

}