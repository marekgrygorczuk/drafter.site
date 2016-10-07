<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 07.10.16
 * Time: 23:45
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Ride;

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

    public function get($rideId)
    {
        if (isset($this->rides[$rideId])) return $this->rides[$rideId];
        return null;
    }

    public function remove($getId)
    {
        unset($this->rides[$getId]);
        return true;
    }
}