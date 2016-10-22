<?php

namespace tests\AppBundle\Entity;

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
}
