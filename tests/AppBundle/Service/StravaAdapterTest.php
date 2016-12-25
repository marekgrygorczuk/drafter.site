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
use AppBundle\Repository\StravaRideRepository;
use AppBundle\Service\StravaAdapter;

class StravaAdapterTest extends \PHPUnit_Framework_TestCase
{
    /** @var  StravaAdapter */
    private $stravaAdapter;
    /** @var  StravaRideRepository | \PHPUnit_Framework_MockObject_MockObject */
    private $stravaRideRepository;

    public function setUp()
    {
        $this->stravaRideRepository = $this->getMockBuilder(StravaRideRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->stravaAdapter = new StravaAdapter($this->stravaRideRepository);
    }

    //later, for now simple mapping
    public function testReturnsAllStravaRidesAsDrafterRides()
    {
        $stravaRide1 = new StravaRide();
        $stravaRide1->occurrences = [new \DateTime()];
        $stravaRide2 = new StravaRide();
        $stravaRide2->occurrences = [new \DateTime()];

        $this->stravaRideRepository->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue([$stravaRide1, $stravaRide2]));

        $this->assertEquals(2, count($this->stravaAdapter->findAllRides()));
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
