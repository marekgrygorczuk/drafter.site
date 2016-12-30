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
            if (!empty($filters->minRideDistance)) {
                if ($rideItem->distance < $filters->minRideDistance)
                    continue;
            }
            if (!empty($filters->maxRideDistance)) {
                if ($rideItem->distance > $filters->maxRideDistance)
                    continue;
            }
            if (!empty($filters->latestDate)) {
                if ($rideItem->beginning > $filters->latestDate)
                    continue;
            }
            if (!empty($filters->earliestDate)) {
                if ($rideItem->beginning < $filters->earliestDate)
                    continue;
            }

            $filteredRides[] = $rideItem;
        }
        return $filteredRides;
    }
}