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
use \DateTime;

class FilterServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var  FilterService */
    private $filterService;

    public function setUp()
    {
        $this->filterService = new FilterService();
    }

    public function testServiceWillFilterOutTooFarRides()
    {
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
    public function testServiceWillFilterOutTooShortRides()
    {
        $rideItem1 = new RideListItem();
        $rideItem1->distance = 20;
        $rideItem2 = new RideListItem();
        $rideItem2->distance = 25;
        $rideItem3 = new RideListItem();
        $rideItem3->distance = 30;
        $rideItems = [$rideItem1, $rideItem2, $rideItem3];

        $filters = new RideFilters();
        $filters->minRideDistance= 25;

        $filteredRides = $this->filterService->filterRideItems($rideItems, $filters);
        $this->assertEquals(2, count($filteredRides));
        /** @var RideListItem $filteredRide */
        foreach ($filteredRides as $filteredRide) {
            $this->assertGreaterThanOrEqual(25, $filteredRide->distance);
        }
    }
    public function testServiceWillFilterOutTooLongRides()
    {
        $rideItem1 = new RideListItem();
        $rideItem1->distance = 20;
        $rideItem2 = new RideListItem();
        $rideItem2->distance = 25;
        $rideItem3 = new RideListItem();
        $rideItem3->distance = 30;
        $rideItems = [$rideItem1, $rideItem2, $rideItem3];

        $filters = new RideFilters();
        $filters->maxRideDistance= 25;

        $filteredRides = $this->filterService->filterRideItems($rideItems, $filters);
        $this->assertEquals(2, count($filteredRides));
        /** @var RideListItem $filteredRide */
        foreach ($filteredRides as $filteredRide) {
            $this->assertLessThanOrEqual(25, $filteredRide->distance);
        }
    }
    public function testServiceWillFilterOutTooEarlyRides()
    {
        $rideItem1 = new RideListItem();
        $rideItem1->beginning = new DateTime('2017-01-03 14:00:00');
        $rideItem2 = new RideListItem();
        $rideItem2->beginning = new DateTime('2017-01-04 14:00:00');
        $rideItem3 = new RideListItem();
        $rideItem3->beginning = new DateTime('2017-01-05 14:00:00');
        $rideItem4 = new RideListItem();
        $rideItem4->beginning = new DateTime('2017-01-06 14:00:00');
        $rideItem5 = new RideListItem();
        $rideItem5->beginning = new DateTime('2017-01-07 14:00:00');
        $rideItems = [$rideItem1, $rideItem2, $rideItem3, $rideItem4, $rideItem5];

        $filters = new RideFilters();
        $filters->earliestDate = new DateTime('2017-01-04 14:00:00');

        $filteredRides = $this->filterService->filterRideItems($rideItems, $filters);
        $this->assertEquals(4, count($filteredRides));
        /** @var RideListItem $filteredRide */
        foreach ($filteredRides as $filteredRide) {
            $this->assertGreaterThanOrEqual(new DateTime('2017-01-04 14:00:00'), $filteredRide->beginning);
        }
    }
    public function testServiceWillFilterOutTooLateRides()
    {
        $rideItem1 = new RideListItem();
        $rideItem1->beginning = new DateTime('2017-01-03 14:00:00');
        $rideItem2 = new RideListItem();
        $rideItem2->beginning = new DateTime('2017-01-04 14:00:00');
        $rideItem3 = new RideListItem();
        $rideItem3->beginning = new DateTime('2017-01-05 14:00:00');
        $rideItem4 = new RideListItem();
        $rideItem4->beginning = new DateTime('2017-01-06 14:00:00');
        $rideItem5 = new RideListItem();
        $rideItem5->beginning = new DateTime('2017-01-07 14:00:00');
        $rideItems = [$rideItem1, $rideItem2, $rideItem3, $rideItem4, $rideItem5];

        $filters = new RideFilters();
        $filters->latestDate = new DateTime('2017-01-04 14:00:00');

        $filteredRides = $this->filterService->filterRideItems($rideItems, $filters);
        $this->assertEquals(2, count($filteredRides));
        /** @var RideListItem $filteredRide */
        foreach ($filteredRides as $filteredRide) {
            $this->assertLessThanOrEqual(new DateTime('2017-01-04 14:00:00'), $filteredRide->beginning);
        }
    }
}
