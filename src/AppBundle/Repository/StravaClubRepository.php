<?php

namespace AppBundle\Repository;

use AppBundle\Entity\StravaClub;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;

class StravaClubRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->StravaClubRepository = $this->entityManager->getRepository('AppBundle:StravaClub');

    }

    public function add(StravaClub $club) : bool
    {
        //it should be replaced with find(), but find is not implemented yet
        try {
            $this->get($club->id);
        } catch (\Exception $e) {
            return false;
        }
        $this->entityManager->persist($club);
        $this->entityManager->flush();
        return true;
    }

    public function get(int $clubId) : StravaClub
    {
        $club = $this->StravaClubRepository->find($clubId);
        if (!$club) throw new \Exception('no club found');
        return $club;
    }

    public function removeAll() : bool
    {
        $this->entityManager->createQuery('DELETE FROM AppBundle:StravaClub')->execute();
        $this->entityManager->flush();
        return true;
    }
}
