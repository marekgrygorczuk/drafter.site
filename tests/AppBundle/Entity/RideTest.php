<?php

namespace tests\AppBundle\Entity;

use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\Ride;

class RideTest extends \PHPUnit_Framework_TestCase
{
    public function testPhpUnit()
    {
        $this->assertTrue(true);
    }

    public function testCreatesRideFromDto()
    {
        $newRideDto = new NewRideDto();
        $expectedName = 'ride name';
        $newRideDto->name = $expectedName;
        $expectedDate = new \DateTime();
        $newRideDto->rideBeginning = $expectedDate;
        $expectedLocation = 'warsaw';
        $newRideDto->rideLocation = $expectedLocation;
        $ride = Ride::newRideFromDto($newRideDto);
        $this->assertEquals($expectedName, $ride->getName());
        $this->assertEquals($expectedDate, $ride->getBeginning());
        $this->assertEquals($expectedLocation, $ride->getLocation());
    }
}
