<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 22.12.16
 * Time: 20:48
 */

namespace tests\AppBundle\Service;


use AppBundle\Entity\Ride;
use AppBundle\Entity\StravaRide;
use AppBundle\Service\StravaAdapter;

class StravaAdapterTest extends \PHPUnit_Framework_TestCase
{
    /** @var  StravaAdapter */
    private $stravaAdapter;

    public function setUp()
    {
        $this->stravaAdapter = new StravaAdapter();
    }

    //later, for now simple mapping
    public function testReturnsAllStravaRidesAsDrafterRides()
    {
        $stravaRide = new StravaRide();
        $expectedDrafterRide = new Ride();
    }

    public function testMapsSingleOccurrenceStravaRideToOneDrafterRide()
    {
        $stravaRide = new StravaRide();
        $stravaRide->title = 'Ride Title';
        $stravaRide->address = 'Ride address';
        $stravaRide->occurrences = [new \DateTime('2016-01-01')];

        $drafterRide = $this->stravaAdapter->mapToDrafterRides($stravaRide)[0];
        $this->assertEquals('Ride Title', $drafterRide->name);
        $this->assertEquals('Ride address', $drafterRide->locationDescription);
        $this->assertEquals(new \DateTime('2016-01-01'), $drafterRide->beginning);
        $this->assertEquals('', $drafterRide->gpsLon);
        $this->assertEquals('', $drafterRide->gpsLat);
        $this->assertEquals(null, $drafterRide->distance);
        $this->assertEquals(null, $drafterRide->gear); //well, impossible to fetch from strava;
    }

    public function testMapsDoubleOccurrencesStravaRideToTwoDrafterRides()
    {
        $stravaRide = new StravaRide();
        $stravaRide->title = 'Ride Title';
        $stravaRide->address = 'Ride address';
        $stravaRide->occurrences = [new \DateTime('2016-01-01'), new \DateTime('2016-01-02')];

        $drafterRides = $this->stravaAdapter->mapToDrafterRides($stravaRide);
        $this->assertEquals(new \DateTime('2016-01-01'), $drafterRides[0]->beginning);
        $this->assertEquals(new \DateTime('2016-01-02'), $drafterRides[1]->beginning);
    }
}
