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

    public function testWillHummerRideUsingRideStamp()
    {
        $firstDay = new \DateTime('2016-10-21');
        $lastDay = new \DateTime('2016-10-21');
        $expectedRide = new Ride;

        $rideStamp = $this->getMockBuilder(RideStamp::class)
            ->disableOriginalConstructor()
            ->getMock();
        $rideStamp->expects($this->once())
            ->method("createRideForThisDay")
            ->with(new \DateTime('2016-10-21'))
            ->will($this->returnValue($expectedRide));
        $rideStamp->expects($this->once())
            ->method("doesItHappenOn")
            ->with(new \DateTime('2016-10-21'))
            ->will($this->returnValue(true));

        $rides = $this->mint->hammerRides($rideStamp, $firstDay, $lastDay);
        $this->assertEquals(1, count($rides));
        /** @var Ride $ride */
        $this->assertSame($expectedRide, $rides[0]);
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
