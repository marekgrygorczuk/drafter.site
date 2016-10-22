<?php
namespace AppBundle\Dto;

class NewRideDto
{
    public $user;
    public $name;
    public $rideLocation;
    /**
     * @var \DateTime
     */
    public $rideBeginning;
}