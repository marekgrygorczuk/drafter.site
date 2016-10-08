<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Ride;
use Doctrine\ORM\EntityManager;

class DatabaseRideRepository implements RideRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Ride $ride) : bool
    {
        $this->entityManager->persist($ride);
        $this->entityManager->flush();
        return true;
    }

    public function find(array $searchArguments) : array
    {
        // TODO: Implement find() method.
    }

    public function findAll() : array
    {
        // TODO: Implement findAll() method.
    }

    public function remove(int $rideId) : bool
    {
        // TODO: Implement remove() method.
    }

    public function get(int $rideId) : Ride
    {
        // TODO: Implement get() method.
    }

    public function removeAll() : bool
    {
        // TODO: Implement removeAll() method.
    }
}