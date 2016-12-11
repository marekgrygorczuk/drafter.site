<?php

namespace AppBundle\Service;


class StravaService
{
    public function authorizeToken($code)
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
            CURLOPT_POSTFIELDS =>$payload
        ];

        $ch = curl_init();

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        $errno    = curl_errno($ch);

        var_dump($errno);
        var_dump($error);
        var_dump($response);

        curl_close($ch);
        return $response;
    }
}