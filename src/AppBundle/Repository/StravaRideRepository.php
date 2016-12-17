<?php

namespace AppBundle\Repository;

use AppBundle\Entity\StravaClub;
use AppBundle\Entity\StravaRide;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;

class StravaRideRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->StravaClubRepository = $this->entityManager->getRepository('AppBundle:StravaRide');

    }

    public function add(StravaRide $club) : bool
    {
        //it should be replaced with find(), but find is not implemented yet
        try {
            $this->get($club->id);
        } catch (\Exception $e) {
            $this->entityManager->persist($club);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }

    public function get(int $clubId) : StravaRide
    {
        $club = $this->StravaClubRepository->find($clubId);
        if (!$club) throw new \Exception('no ride found');
        return $club;
    }

    public function removeAll() : bool
    {
        $this->entityManager->createQuery('DELETE FROM AppBundle:StravaRide')->execute();
        $this->entityManager->flush();
        return true;
    }
}