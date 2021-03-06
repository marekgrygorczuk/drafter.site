<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 03.12.16
 * Time: 13:30
 */

namespace AppBundle\Dto;


class RideFilters
{
    /**
     * @var int
     */
    public $maxDistanceFromUser;
    /**
     * @var int
     */
    public $minRideDistance;
    /**
     * @var int
     */
    public $maxRideDistance;
    /** 
     * @var \DateTime
     */
    public $earliestDate;
    /** 
     * @var \DateTime
     */
    public $latestDate;
    /**
     * @var array
     */
    public $gears;
    /**
     * @var int
     */
    public $hours;
    /**
     * @var int
     */
    public $minutes;
    /**
     * @var bool
     */
    public $hasLocation;
}