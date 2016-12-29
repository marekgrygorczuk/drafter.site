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

    public function __construct(StravaClubRepository $repository, StravaRideRepository $rideRepository, StravaApiClient $stravaApiClient)
    {
        $this->clubRepository = $repository;
        $this->rideRepository = $rideRepository;
        $this->stravaApiClient = $stravaApiClient;
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
        $response = $this->stravaApiClient->fetchClubEvents($clubId, $access_token);

        $clubRides = json_decode($response, true);
        if (!empty($clubRides['errors'])) return;
        foreach ($clubRides as $clubRide) {
            $newClubRide = new StravaRide();
            $newClubRide->id = $clubRide['id'];
            $newClubRide->title = $clubRide['title'];
            $newClubRide->description = $clubRide['description'];
            $newClubRide->club_id = $clubRide['club_id'];
            $newClubRide->activity_type = $clubRide['activity_type'];
            $newClubRide->route_id = $clubRide['route_id'];
            $newClubRide->address = $clubRide['address'];
            $newClubRide->private = $clubRide['private'];
            $newClubRide->occurrences = [];
            foreach ($clubRide["upcoming_occurrences"] as $upcoming_occurrence) {
                $newClubRide->occurrences[] = new \DateTime($upcoming_occurrence);
            }
            $this->rideRepository->add($newClubRide);
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