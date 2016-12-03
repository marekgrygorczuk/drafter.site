<?php
namespace AppBundle\Service;

use AppBundle\Dto\RideFilters;
use AppBundle\Dto\RideListItem;

class FilterService {
    /**
     * @param array $rideItems
     * @param RideFilters $filters
     * @return array
     */
    public function filterRideItems(array $rideItems, RideFilters $filters) : array {
        $filteredRides = [];
        /** @var RideListItem $rideItem */
        foreach ($rideItems as $rideItem) {
            if (!empty($filters->maxDistanceFromUser)) {
                if ($rideItem->distanceToUser > $filters->maxDistanceFromUser)
                    continue;
            }
            $filteredRides[] = $rideItem;
        }
        return $filteredRides;
    }
}