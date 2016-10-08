<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Ride;
use Symfony\Component\Config\Definition\Exception\Exception;

class MemoryRideRepository implements RideRepositoryInterface
{
    /**
     * @var array
     */
    private $rides;

    public function __construct()
    {
        $this->rides = [];
    }

    public function add(Ride $ride) : bool
    {
        $this->rides[$ride->getId()] = $ride;
        return true;
    }

    public function find(array $searchArguments) : array
    {
        // TODO: Implement find() method.
    }

    public function get(int $rideId) : Ride
    {
        if (isset($this->rides[$rideId])) return $this->rides[$rideId];
        throw new \Exception("Ride with id ".$rideId." not found.");
    }

    public function remove(int $getId) : bool
    {
        unset($this->rides[$getId]);
        return true;
    }

    public function findAll() : array
    {
        return $this->rides;
    }

    public function removeAll() : bool
    {
        $this->rides = [];
        return true;
    }
}