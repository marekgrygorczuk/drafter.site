<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 03.12.16
 * Time: 14:46
 */

namespace tests\AppBundle\Service;


use AppBundle\Dto\RideFilters;
use AppBundle\Dto\RideListItem;
use AppBundle\Service\FilterService;

class FilterServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var  FilterService */
    private $filterService;

    public function setUp() {
        $this->filterService = new FilterService();
    }
    public function testServiceWillFilterOutTooFarRides() {
        $rideItem1 = new RideListItem();
        $rideItem1->distanceToUser = 20;
        $rideItem2 = new RideListItem();
        $rideItem2->distanceToUser = 25;
        $rideItem3 = new RideListItem();
        $rideItem3->distanceToUser = 30;
        $rideItems = [$rideItem1, $rideItem2, $rideItem3];

        $filters = new RideFilters();
        $filters->maxDistanceFromUser = 25;

        $filteredRides = $this->filterService->filterRideItems($rideItems, $filters);
        $this->assertEquals(2, count($filteredRides));
        /** @var RideListItem $filteredRide */
        foreach ($filteredRides as $filteredRide) {
            $this->assertLessThanOrEqual(25, $filteredRide->distanceToUser);
        }
    }
}
