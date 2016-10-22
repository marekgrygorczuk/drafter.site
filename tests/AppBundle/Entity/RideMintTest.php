<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 22.10.16
 * Time: 14:04
 */

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
        $this->mint = new RideMint();
        $rideStamp = new RideStamp();
        $rideStamp->setDayOfWeekOccurrence(RideStamp::FRIDAY);
        $firstDay = new \DateTime('2016-10-21');
        $lastDay = new \DateTime('2016-10-21');
        $rides = $this->mint->hammerRides($rideStamp, $firstDay, $lastDay);
        $this->assertEquals(1, count($rides));
        /** @var Ride $ride */
        foreach ($rides as $ride) {
            $this->assertEquals($firstDay->format('Y-m-d'), $ride->getBeginning()->format('Y-m-d'));
        }
    }

    public function testWillHummer4RidesFor4Weeks()
    {
        $this->mint = new RideMint();
        $rideStamp = new RideStamp();
        $rideStamp->setDayOfWeekOccurrence(RideStamp::FRIDAY);
        $firstDay = new \DateTime('2016-10-03');
        $lastDay = new \DateTime('2016-10-30');
        $rides = $this->mint->hammerRides($rideStamp, $firstDay, $lastDay);
        $this->assertEquals(4, count($rides));
    }

    public function testWillHummerNoRideForWrongDay()
    {
        $this->mint = new RideMint();
        $rideStamp = new RideStamp();
        $rideStamp->setDayOfWeekOccurrence(RideStamp::FRIDAY);
        $firstDay = new \DateTime('2016-10-22');
        $lastDay = new \DateTime('2016-10-22');
        $rides = $this->mint->hammerRides($rideStamp, $firstDay, $lastDay);
        $this->assertEquals(0, count($rides));
    }
}
