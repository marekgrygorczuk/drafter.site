<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Ride;
use AppBundle\Entity\RideStamp;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseRideStampRepositoryTest extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /** @var  DatabaseRideStampRepository */
    private $repository;
    /** @var  RideStamp */
    private $rideStamp1;
    /** @var  RideStamp */
    private $rideStamp2;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->repository = new DatabaseRideStampRepository($this->em);
        $this->rideStamp1 = new RideStamp();
        $this->rideStamp1->rideName = 'Masa';
        $this->rideStamp1->rideClockHour = 17;
        $this->rideStamp1->rideClockMinute = 30;
        $this->rideStamp1->rideLocation = 'Warsaw';
        $this->rideStamp1->setDayOfWeekOccurrence(RideStamp::FRIDAY);
        $this->rideStamp2 = new RideStamp();
        $this->rideStamp2->rideName = 'Babka';
        $this->rideStamp2->rideClockHour = 9;
        $this->rideStamp2->rideClockMinute = 00;
        $this->rideStamp2->rideLocation = 'Warsaw';
        $this->rideStamp2->setDayOfWeekOccurrence(RideStamp::SATURDAY);
    }

    public function testRepositoryWillSavePersistedObject()
    {
        $this->repository->add($this->rideStamp1);

        $this->assertSame($this->rideStamp1, $this->repository->get($this->rideStamp1->getId()));
    }

    public function testRepositoryWillRemoveGivenObjectByGivenId()
    {
        $this->repository->add($this->rideStamp1);

        $this->assertSame($this->rideStamp1, $this->repository->get($this->rideStamp1->getId()));

        $this->repository->remove($this->rideStamp1->getId());
        $this->assertEquals(0, count($this->repository->findAll()));
    }

    public function testRepositoryWillReturnAllSavedRides()
    {
        $this->repository->add($this->rideStamp1);
        $this->repository->add($this->rideStamp2);

        $this->assertEquals(2, count($this->repository->findAll()));
    }

    public function testRepositoryCanRemoveAllSavedRides()
    {
        $this->repository->add($this->rideStamp1);
        $this->repository->add($this->rideStamp2);

        $this->assertEquals(2, count($this->repository->findAll()));
        $this->repository->removeAll();
        $this->assertEquals(0, count($this->repository->findAll()));
    }

    public function tearDown()
    {
        $this->repository->removeAll();
    }
}
