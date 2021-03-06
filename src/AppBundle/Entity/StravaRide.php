<?php

namespace AppBundle\Entity;


use AppBundle\Service\GpsLocation;

class StravaRide
{
    public $id;
    public $title;
    public $description;
    public $club_id;
    public $activity_type;
    public $created_at;
    public $route_id;
    public $private;
    public $upcoming_occurrences;
    public $address;
    /** @var  \DateTime[] */
    public $occurrences;
    /** @var  GpsLocation */
    public $gpsLocation;
    public $distance;
}