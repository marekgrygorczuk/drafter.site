<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Ride;

interface RideRepositoryInterface
{
    public function add(Ride $ride) : bool;
    public function find(array $searchArguments) : array;
}