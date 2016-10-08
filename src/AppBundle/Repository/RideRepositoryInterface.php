<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Ride;

interface RideRepositoryInterface
{
    public function add(Ride $ride) : bool;
    public function remove(int $rideId) : bool;
    public function get(int $rideId) : Ride;
    public function find(array $searchArguments) : array;
    public function findAll() : array;
    public function removeAll() : bool;
}