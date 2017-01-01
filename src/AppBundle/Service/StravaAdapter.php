<?php

namespace AppBundle\Service;


use AppBundle\Entity\Ride;
use AppBundle\Entity\StravaRide;
use AppBundle\Repository\StravaRideRepository;

class StravaAdapter
{
    /**
     * @var StravaRideRepository
     */
    private $stravaRideRepository;

    public function __construct(StravaRideRepository $stravaRideRepository)
    {
        $this->stravaRideRepository = $stravaRideRepository;
    }

    public function mapToDrafterRides(StravaRide $stravaRide) : array
    {
        $drafterRides = [];
        foreach ($stravaRide->occurrences as $occurrence) {
            $drafterRide = new Ride();
            $drafterRide->name = $stravaRide->title;
            $drafterRide->locationDescription = $stravaRide->address;
            $drafterRide->gpsLat = $stravaRide->gpsLocation->getLat();
            $drafterRide->gpsLon = $stravaRide->gpsLocation->getLon();
            $drafterRide->beginning = $occurrence;
            $drafterRide->distance = $stravaRide->distance;
            $drafterRides[] = $drafterRide;
        }
        return $drafterRides;
    }

    public function findAllRides() : array
    {
        $stravaRides = $this->stravaRideRepository->findAll();
        $drafterRides = [];
        foreach ($stravaRides as $stravaRide) {
            foreach ($this->mapToDrafterRides($stravaRide) as $drafterRide) {
                $drafterRides[] = $drafterRide;
            }
        }
        return $drafterRides;
    }
}