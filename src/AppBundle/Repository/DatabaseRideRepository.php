<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Ride;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DatabaseRideRepository implements RideRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var EntityRepository
     */
    private $rideRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->rideRepository = $this->entityManager->getRepository('AppBundle:Ride');

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
        return $this->rideRepository->findAll();
    }

    public function findUpcomingRides() : array
    {
        $rides = $this->entityManager
            ->createQuery('SELECT r FROM AppBundle:Ride r WHERE r.beginning > CURRENT_TIMESTAMP() ORDER BY r.beginning ASC')
            ->getResult();
        return $rides;
    }

    public function remove(int $rideId) : bool
    {
        $rideToDelete = $this->get($rideId);
        $this->entityManager->remove($rideToDelete);
        $this->entityManager->flush();
        return true;
    }

    public function get(int $rideId) : Ride
    {
        return $this->rideRepository->find($rideId);
    }

    public function removeAll() : bool
    {
        $this->entityManager->createQuery('DELETE FROM AppBundle:Ride')->execute();
        $this->entityManager->flush();
        return true;
    }
}