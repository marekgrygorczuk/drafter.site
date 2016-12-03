<?php

namespace AppBundle\Entity;


class RideMint
{
    public function hammerRides(RideStamp $stamp, \DateTime $firstDay, \DateTime $lastDay) : array
    {
        $rides = [];
        for ($day = clone $firstDay; $day <= $lastDay; $day->add(new \DateInterval('P1D'))) {
            if ($stamp->doesItHappenOn($day)) {
                $rides[] = $stamp->createRideForThisDay($day);
            }
        }
        return $rides;
    }
}