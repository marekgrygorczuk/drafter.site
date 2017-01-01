<?php

namespace tests\AppBundle\Service;

use AppBundle\Service\StravaApiClient;

class StravaApiClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var StravaApiClient */
    private $stravaApiClient;

    public function setUp()
    {
        $this->stravaApiClient = new StravaApiClient(15357, 'd216f9dc50751b91dad9d2efb6c143aff38943dd'); //same as in config_dev
    }

    public function testFetchesRoute()
    {
        $routeId = 7282090;
        $accessToken = 'd996facf7958fbace908117e283ca1924407d9ce';
        $stravaRoute = $this->stravaApiClient->fetchRoute($routeId, $accessToken);
    }
    public function testFetchesRouteStream()
    {
        $routeId = 7282090;
        $accessToken = 'd996facf7958fbace908117e283ca1924407d9ce';
        $stravaRouteStream = $this->stravaApiClient->fetchRouteStream($routeId, $accessToken);
        var_dump($stravaRouteStream);
    }
}
