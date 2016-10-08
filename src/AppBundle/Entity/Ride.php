<?php
namespace AppBundle\Entity;

class Ride
{
    /**
     * @var string
     */
    private $location;
    /**
     * @var \DateTime
     */
    private $beginning;
    /**
     * @var User
     */
    private $owner;
    /**
     * @var int
     */
    private $id;

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

}