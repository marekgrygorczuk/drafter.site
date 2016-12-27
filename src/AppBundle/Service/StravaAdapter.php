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
            $drafterRide->beginning = $occurrence;
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