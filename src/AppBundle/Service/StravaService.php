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

    public function __construct(StravaClubRepository $repository, StravaRideRepository $rideRepository)
    {
        $this->clubRepository = $repository;
        $this->rideRepository = $rideRepository;
    }

    public function authorizeToken($code) : string
    {
        $payload = [
            'client_id' => 15104,
            'client_secret' => '93aeeb840e85c19a751c1c22ad7ea9b23f7e9b40',
            'code' => $code
        ];

        $options = [
            CURLOPT_URL => 'https://www.strava.com/oauth/token',
            CURLOPT_HEADER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_RETURNTRANSFER => true
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
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
        $options = [
            CURLOPT_URL => 'https://www.strava.com/api/v3/clubs/' . $clubId . '/group_events',//?upcoming=true',
            CURLOPT_HTTPHEADER => ["Authorization: Bearer " . $access_token],
            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_POST => true,
//            CURLOPT_POSTFIELDS => ['upcoming' => true],
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

//        var_dump($response);
        $clubRides = json_decode($response, true);
        var_dump($clubRides);
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
}