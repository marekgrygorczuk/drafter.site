<?php

namespace AppBundle\Repository;


use AppBundle\Entity\RideStamp;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DatabaserideStampRepository implements rideStampRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var EntityRepository
     */
    private $rideStampRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->rideStampRepository = $this->entityManager->getRepository('AppBundle:RideStamp');

    }

    public function add(RideStamp $stamp) : bool
    {
        $this->entityManager->persist($stamp);
        $this->entityManager->flush();
        return true;
    }

    public function find(array $searchArguments) : array
    {
        // TODO: Implement find() method.
    }

    public function findAll() : array
    {
        return $this->rideStampRepository->findAll();
    }

    public function remove(int $stampId) : bool
    {
        $stampToDelete = $this->get($stampId);
        $this->entityManager->remove($stampToDelete);
        $this->entityManager->flush();
        return true;
    }

    public function get(int $stampId) : RideStamp
    {
        return $this->rideStampRepository->find($stampId);
    }

    public function removeAll() : bool
    {
        $this->entityManager->createQuery('DELETE FROM AppBundle:RideStamp')->execute();
        $this->entityManager->flush();
        return true;
    }
}