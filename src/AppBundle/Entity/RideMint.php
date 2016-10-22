<?php

namespace AppBundle\Entity;


class RideMint
{
    public function hammerRides(RideStamp $stamp, \DateTime $firstDay, \DateTime $lastDay)
    {
        $rides = [];
        for ($day = clone $firstDay; $day <= $lastDay; $day->add(new \DateInterval('P1D'))) {
            if ($stamp->doesItHappenOn($day))
                $rides[] = new Ride('nowhere', clone $day, 'noname');
        }
        return $rides;
    }
}