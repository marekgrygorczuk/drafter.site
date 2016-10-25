<?php

namespace tests\AppBundle\Entity;


use AppBundle\Entity\Ride;
use AppBundle\Entity\RideMint;
use AppBundle\Entity\RideStamp;

class RideMintTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RideMint
     */
    private $mint;

    public function setUp()
    {
        $this->mint = new RideMint();
    }

    public function testWillHummerRideForRightDay()
    {
        $expectedName = "expectedNAme";
        $expectedLocation = "expectedLocation";
        $expectedClockHour = 9;
        $expectedClockMinute = 15;

        $rideStamp = new RideStamp();
        $rideStamp->rideName = $expectedName;
        $rideStamp->rideLocation = $expectedLocation;
        $rideStamp->setDayOfWeekOccurrence(RideStamp::FRIDAY);
        $rideStamp->rideClockHour = $expectedClockHour;
        $rideStamp->rideClockMinute = $expectedClockMinute;

        $firstDay = new \DateTime('2016-10-21');
        $lastDay = new \DateTime('2016-10-21');

        $rides = $this->mint->hammerRides($rideStamp, $firstDay, $lastDay);
        $this->assertEquals(1, count($rides));
        /** @var Ride $ride */
        foreach ($rides as $ride) {
            $this->assertEquals($firstDay->format('Y-m-d'), $ride->getBeginning()->format('Y-m-d'));
            $this->assertEquals($expectedName, $ride->getName());
            $this->assertEquals($expectedLocation, $ride->getLocation());
            $this->assertEquals($expectedClockHour, (int)$ride->getBeginning()->format("H"));
            $this->assertEquals($expectedClockMinute, (int)$ride->getBeginning()->format("i"));
        }
    }

    public function testWillHummer4RidesFor4Weeks()
    {
        $rideStamp = new RideStamp();
        $rideStamp->setDayOfWeekOccurrence(RideStamp::FRIDAY);
        $firstDay = new \DateTime('2016-10-03');
        $lastDay = new \DateTime('2016-10-30');
        $rides = $this->mint->hammerRides($rideStamp, $firstDay, $lastDay);
        $this->assertEquals(4, count($rides));
    }

    public function testWillHummerNoRideForWrongDay()
    {
        $rideStamp = new RideStamp();
        $rideStamp->setDayOfWeekOccurrence(RideStamp::FRIDAY);
        $firstDay = new \DateTime('2016-10-22');
        $lastDay = new \DateTime('2016-10-22');
        $rides = $this->mint->hammerRides($rideStamp, $firstDay, $lastDay);
        $this->assertEquals(0, count($rides));
    }
}
