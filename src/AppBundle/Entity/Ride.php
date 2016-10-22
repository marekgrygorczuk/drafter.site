<?php
namespace AppBundle\Entity;

class Ride
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
    public $location;
    /**
     * @var \DateTime
     */
    public $beginning;
    /**
     * @var User
     */
    public $owner;

    public function __construct(User $owner, string $location, \DateTime $beginning)
    {
        $this->location = $location;
        $this->beginning = $beginning;
        $this->owner = $owner;
        $this->id = mt_rand();
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
     * @param string $location
     *
     * @return Ride
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
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
     * Set owner
     *
     * @param \AppBundle\Entity\User $owner
     *
     * @return Ride
     */
    public function setOwner(\AppBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \AppBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
