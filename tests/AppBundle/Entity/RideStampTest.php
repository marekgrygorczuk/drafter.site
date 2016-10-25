<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Ride;
use AppBundle\Entity\RideStamp;

class RideStampTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dates
     * @param $expected
     * @param $date
     * @throws \Exception
     */
    public function testRideStampsAbilityToDeclareOccurrenceOnGivenDay($date, $dayOfWeek, $expected)
    {
        $rideStamp = new RideStamp();
        $rideStamp->setDayOfWeekOccurrence($dayOfWeek);
        $this->assertEquals($expected, $rideStamp->doesItHappenOn($date));
    }

    public function dates()
    {
        return [
            [new \DateTime('2016-10-22'), RideStamp::SATURDAY, true],
            [new \DateTime('2016-10-22'), RideStamp::SUNDAY, false],
            [new \DateTime('2016-10-22'), RideStamp::MONDAY, false],
            [new \DateTime('2016-10-23'), RideStamp::SUNDAY, true],
        ];
    }

    public function testRideHasNewIdDuringCreation()
    {
        $rideStamp = new RideStamp();
        $this->assertNotNull($rideStamp->getId());
    }

    public function testRideStampCreatesRideForCertainDay()
    {
        $expectedName = 'ride name';
        $expectedDate = new \DateTime();
        $expectedLocation = 'warsaw';
        $expectedGear = Ride::GEAR_ANY;
        $expectedLat = 50;
        $expectedLon = 20;
        $expectedDistance = 120;
        $expectedClockHour = 9;
        $expectedClockMinute = 15;

        $rideStamp = new RideStamp();

        $rideStamp->name = $expectedName;
        $rideStamp->setDayOfWeekOccurrence(RideStamp::FRIDAY);
        $rideStamp->rideClockHour = $expectedClockHour;
        $rideStamp->rideClockMinute = $expectedClockMinute;
        $rideStamp->name = $expectedName;
        $rideStamp->locationDescription = $expectedLocation;
        $rideStamp->gpsLon = $expectedLon;
        $rideStamp->gpsLat = $expectedLat;
        $rideStamp->distance = $expectedDistance;
        $rideStamp->gear = $expectedGear;


        $ride = $rideStamp->createRideForThisDay($expectedDate);

        $this->assertEquals($expectedName, $ride->getName());
        $this->assertEquals($expectedLocation, $ride->getLocationDescription());
        $this->assertEquals($expectedLon, $ride->gpsLon);
        $this->assertEquals($expectedLat, $ride->gpsLat);
        $this->assertEquals($expectedDistance, $ride->distance);
        $this->assertEquals($expectedGear, $ride->gear);
        $this->assertEquals($expectedDate->format('Y-m-d'), $ride->getBeginning()->format('Y-m-d'));
        $this->assertEquals($expectedClockHour, (int)$ride->getBeginning()->format("H"));
        $this->assertEquals($expectedClockMinute, (int)$ride->getBeginning()->format("i"));
    }
}
