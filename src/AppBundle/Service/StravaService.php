<?php

namespace AppBundle\Service;

use AppBundle\Entity\StravaClub;
use AppBundle\Entity\StravaRide;
use AppBundle\Repository\StravaClubRepository;
use AppBundle\Repository\StravaRideRepository;

class StravaService
{
    /**
     * @var StravaClubRepository
     */
    private $clubRepository;
    /**
     * @var StravaRideRepository
     */
    private $rideRepository;
    /**
     * @var StravaApiClient
     */
    private $stravaApiClient;
    /**
     * @var StravaJsonMapper
     */
    private $stravaMapper;

    public function __construct(StravaClubRepository $repository, StravaRideRepository $rideRepository, StravaApiClient $stravaApiClient, StravaJsonMapper $stravaJsonMapper)
    {
        $this->clubRepository = $repository;
        $this->rideRepository = $rideRepository;
        $this->stravaApiClient = $stravaApiClient;
        $this->stravaMapper = $stravaJsonMapper;
    }

    public function saveNewClub($clubArray) : bool
    {
        $club = new StravaClub();
        $club->id = $clubArray['id'];
        $club->name = $clubArray['name'];
        $club->city = $clubArray['city'];
        $club->state = $clubArray['state'];
        $club->country = $clubArray['country'];
        $club->private = $clubArray['private'];

        $this->clubRepository->add($club);
        return true;
    }

    public function importClubEvents($clubId, $access_token) // : void //as of 7.1
    {
        $clubJson = $this->stravaApiClient->fetchClubEvents($clubId, $access_token);

        $clubRides = json_decode($clubJson, true);
        if (!empty($clubRides['errors'])) return;
        foreach ($clubRides as $clubRide) {
            $stravaRide = $this->stravaMapper->stravaRideFromJson($clubRide);
            if (!empty($stravaRide->route_id)) {
                $routeStreamJson = $this->stravaApiClient->fetchRouteStream($stravaRide->route_id, $access_token);
                $routeStreamArray = json_decode($routeStreamJson, true);
                $stravaRide->gpsLocation = $this->stravaMapper->beginningOfRouteStream($routeStreamArray);
                $stravaRide->distance = $this->stravaMapper->distanceOfRouteStream($routeStreamArray);
            }
            $this->rideRepository->add($stravaRide);
        }
    }

    public function synchronizeUserWithStrava($code)
    {
        $response = $this->stravaApiClient->authorizeToken($code);
        $response = json_decode($response, true);
        $access_token = $response['access_token'];
        foreach ($response['athlete']['clubs'] as $club) {
            $this->saveNewClub($club);
            $this->importClubEvents($club['id'], $access_token);
        }
    }
}