<?php

namespace AppBundle\Service;


class StravaApiClient
{
    private $clientId;
    private $clientSecret;

    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function authorizeToken($code) : string
    {
        $payload = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
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

    public function fetchClubEvents($clubId, $access_token)
    {
        $options = [
            CURLOPT_URL => 'https://www.strava.com/api/v3/clubs/' . $clubId . '/group_events',//?upcoming=true',
            CURLOPT_HTTPHEADER => ["Authorization: Bearer " . $access_token],
            CURLOPT_RETURNTRANSFER => true,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function fetchRoute($routeId, $accessToken)
    {
        $options = [
            CURLOPT_URL => 'https://www.strava.com/api/v3/routes/' . $routeId,
            CURLOPT_HTTPHEADER => ["Authorization: Bearer " . $accessToken],
            CURLOPT_RETURNTRANSFER => true,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}