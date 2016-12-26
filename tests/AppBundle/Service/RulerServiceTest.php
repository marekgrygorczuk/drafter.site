<?php

namespace tests\AppBundle\Service;


use AppBundle\Service\GpsLocation;
use AppBundle\Service\RulerService;

class RulerServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsDistanceBetweenTwoGpsPointsInKms()
    {
        $ruler = new RulerService();
        $cracow = new GpsLocation(50, 20);
        $zero = new GpsLocation(0, 0);
        $london = new GpsLocation(51.5, 0);
        $this->assertEquals(1412, $ruler->getDistance($cracow,$london),'',1.0);
        $this->assertEquals(5727, $ruler->getDistance($zero,$london),'',1.0);
        $this->assertEquals(5876, $ruler->getDistance($cracow,$zero),'',1.0);
    }

}
