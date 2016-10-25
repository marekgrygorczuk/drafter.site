<?php

namespace AppBundle\Entity;


class RideMint
{
    public function hammerRides(RideStamp $stamp, \DateTime $firstDay, \DateTime $lastDay)
    {
        $rides = [];
        for ($day = clone $firstDay; $day <= $lastDay; $day->add(new \DateInterval('P1D'))) {
            if ($stamp->doesItHappenOn($day)) {
                /** @var \DateTime $rideStart */
                $rideStart = clone $day;
                $rideStart->setTime($stamp->rideClockHour,$stamp->rideClockMinute);
                $rides[] = new Ride($stamp->rideLocation, $rideStart, $stamp->rideName);
            }
        }
        return $rides;
    }
}