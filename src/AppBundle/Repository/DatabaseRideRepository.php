<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Ride;
use AppBundle\Service\StravaAdapter;
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
    /**
     * @var StravaAdapter
     */
    private $stravaAdapter;

    public function __construct(EntityManager $entityManager, StravaAdapter $stravaAdapter)
    {
        $this->entityManager = $entityManager;
        $this->rideRepository = $this->entityManager->getRepository('AppBundle:Ride');
        $this->stravaAdapter = $stravaAdapter;
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
        return array_merge($this->rideRepository->findAll(), $this->stravaAdapter->findAllRides());
    }

    public function findUpcomingRides() : array
    {
        $rides = $this->entityManager
            ->createQuery('SELECT r FROM AppBundle:Ride r WHERE r.beginning > CURRENT_DATE() AND r.beginning < DATE_ADD(CURRENT_DATE(),7, \'day\') ORDER BY r.beginning ASC')
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