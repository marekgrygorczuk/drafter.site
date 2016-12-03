<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 03.12.16
 * Time: 11:46
 */

namespace AppBundle\Dto;


class RideListItem
{
    /**
     * @var int
     */
    public $id;
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

    /**
     * @var int
     */
    public $distanceToUser;

}