<?php

namespace AppBundle\Service;


use AppBundle\Entity\Ride;
use AppBundle\Entity\StravaRide;

class StravaAdapter
{
    public function mapToDrafterRides(StravaRide $stravaRide) : array
    {
        $drafterRides = [];
        foreach ($stravaRide->occurrences as $occurrence) {
            $drafterRide = new Ride();
            $drafterRide->name = $stravaRide->title;
            $drafterRide->locationDescription = $stravaRide->address;
            $drafterRide->beginning = $occurrence;
            $drafterRides[] = $drafterRide;
        }
        return $drafterRides;
    }
}