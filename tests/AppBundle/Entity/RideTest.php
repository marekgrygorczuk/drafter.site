<?php

namespace tests\AppBundle\Entity;

use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\Ride;

class RideTest extends \PHPUnit_Framework_TestCase
{
    public function testContructorCreatesIntId()
    {
        $ride = new Ride();
        $this->assertInternalType('int', $ride->getId());
    }

    public function testCreatesRideFromDto()
    {
        $newRideDto = new NewRideDto();
        $expectedName = 'ride name';
        $expectedDate = new \DateTime();
        $expectedLocation = 'warsaw';
        $expectedGear = Ride::GEAR_ANY;
        $expectedLat = 50;
        $expectedDistance = 120;
        $expectedLon = 20;

        $newRideDto->name = $expectedName;
        $newRideDto->beginning = $expectedDate;
        $newRideDto->locationDescription = $expectedLocation;
        $newRideDto->gpsLon = $expectedLon;
        $newRideDto->gpsLat = $expectedLat;
        $newRideDto->distance = $expectedDistance;
        $newRideDto->gear = $expectedGear;

        $ride = Ride::newRideFromDto($newRideDto);

        $this->assertEquals($expectedName, $ride->getName());
        $this->assertEquals($expectedDate, $ride->getBeginning());
        $this->assertEquals($expectedLocation, $ride->getLocationDescription());
        $this->assertEquals($expectedLon,$ride->gpsLon);
        $this->assertEquals($expectedLat,$ride->gpsLat);
        $this->assertEquals($expectedDistance,$ride->distance);
        $this->assertEquals($expectedGear,$ride->gear);
    }
}
