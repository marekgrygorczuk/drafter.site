<?php
namespace AppBundle\Entity;

use AppBundle\Dto\NewRideDto;

class Ride
{
    const GEAR_ROAD_BIKE = 'road_bike';
    const GEAR_MTB = 'mtb';
    const GEAR_CX = 'cyclocross';
    const GEAR_TOURING = 'touring';
    const GEAR_RECUMBENT = 'weirdo';
    const GEAR_ANY = 'any_bike';

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


//    /**
//     * @var User
//     */
//    public $owner;

    public function __construct($location = null, \DateTime $beginning = null, $name = null)
    {
        $this->id = mt_rand();
        $this->locationDescription = $location;
        $this->beginning = $beginning;
        $this->name = $name;
    }

    /**
     * @param NewRideDto $dto
     * @return Ride
     */
    public static function newRideFromDto(NewRideDto $dto) : Ride
    {
        $ride = new Ride();
        $ride->name = $dto->name;
        $ride->locationDescription = $dto->locationDescription;
        $ride->gpsLon = $dto->gpsLon;
        $ride->gpsLat = $dto->gpsLat;
        $ride->distance = $dto->distance;
        $ride->gear = $dto->gear;
        $ride->beginning = $dto->beginning;
        return $ride;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Ride
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set location
     *
     * @param string $locationDescription
     *
     * @return Ride
     */
    public function setLocationDescription($locationDescription)
    {
        $this->locationDescription = $locationDescription;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocationDescription()
    {
        return $this->locationDescription;
    }

    /**
     * Set beginning
     *
     * @param \DateTime $beginning
     *
     * @return Ride
     */
    public function setBeginning($beginning)
    {
        $this->beginning = $beginning;

        return $this;
    }

    /**
     * Get beginning
     *
     * @return \DateTime
     */
    public function getBeginning()
    {
        return $this->beginning;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

//    /**
//     * Set owner
//     *
//     * @param \AppBundle\Entity\User $owner
//     *
//     * @return Ride
//     */
//    public function setOwner(\AppBundle\Entity\User $owner = null)
//    {
//        $this->owner = $owner;
//
//        return $this;
//    }
//
//    /**
//     * Get owner
//     *
//     * @return \AppBundle\Entity\User
//     */
//    public function getOwner()
//    {
//        return $this->owner;
//    }
}
