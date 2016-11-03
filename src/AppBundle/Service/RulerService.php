<?php

namespace AppBundle\Service;


class RulerService
{
    function getDistance(GpsLocation $location1, GpsLocation $location2)
    {
        $theta = $location1->getLon() - $location2->getLon();
        $dist = sin(deg2rad($location1->getLat())) * sin(deg2rad($location2->getLat())) + cos(deg2rad($location1->getLat())) * cos(deg2rad($location2->getLat())) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        return round($dist * 60 * 1.1515);
    }
}