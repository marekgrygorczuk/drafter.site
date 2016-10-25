<?php
namespace AppBundle\Dto;

class NewRideDto
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $locationDescription;
    /**
     * @var float
     */
    public $gpsLon;
    /**
     * @var float
     */
    public $gpsLat;
    /**
     * @var \DateTime
     */
    public $beginning;

    /**
     * @var int
     */
    public $distance;

    /**
     * @var string
     */
    public $gear;

}