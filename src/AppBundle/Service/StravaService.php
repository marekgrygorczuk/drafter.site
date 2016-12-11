<?php

namespace AppBundle\Service;

use AppBundle\Entity\StravaClub;
use AppBundle\Repository\StravaClubRepository;

class StravaService
{
    /**
     * @var StravaClubRepository
     */
    private $repository;

    public function __construct(StravaClubRepository $repository)
    {
        $this->repository = $repository;
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
            CURLOPT_POSTFIELDS =>$payload,
            CURLOPT_RETURNTRANSFER => true
        ];

        $ch = curl_init();

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

//        $error    = curl_error($ch);
//        $errno    = curl_errno($ch);


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

        $this->repository->add($club);
        return true;
    }
}