<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 01.01.17
 * Time: 20:28
 */

namespace AppBundle\Service;


use AppBundle\Entity\StravaRide;

class StravaJsonMapper
{
    public function stravaRideFromJson(array $array) : StravaRide
    {
        $stravaRide = new StravaRide();
        $stravaRide->id = $array['id'];
        $stravaRide->title = $array['title'];
        $stravaRide->description = $array['description'];
        $stravaRide->club_id = $array['club_id'];
        $stravaRide->activity_type = $array['activity_type'];
        $stravaRide->route_id = $array['route_id'];
        $stravaRide->address = $array['address'];
        $stravaRide->private = $array['private'];
        $stravaRide->occurrences = [];
        foreach ($array["upcoming_occurrences"] as $upcoming_occurrence) {
            $stravaRide->occurrences[] = new \DateTime($upcoming_occurrence);
        }
        return $stravaRide;
    }
    public function beginningOfRouteStream(array $routeStreamArray) : GpsLocation {
        foreach ($routeStreamArray as $element) {
            if ($element["type"] == "latlng") {
                $lat = $element["data"][0][0];
                $lng = $element["data"][0][1];
                return new GpsLocation($lat, $lng);
            }
        }
        return null;
    }
    public function distanceOfRouteStream(array $routeStreamArray) : int {
        foreach ($routeStreamArray as $element) {
            if ($element["type"] == "distance") {
                return round((int)$element["data"][count($element["data"])-1]/1000);
            }
        }
        return null;
    }
}