<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Ride;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseRideRepositoryTest extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /** @var  DatabaseRideRepository */
    private $repository;
    /**
     * @var Ride
     */
    private $ride1;
    /**
     * @var Ride
     */
    private $ride2;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->repository = new DatabaseRideRepository($this->em);

        $this->ride1 = new Ride();
        $this->ride1->name = 'random ride';
        $this->ride1->locationDescription = 'over there';
        $this->ride1->gpsLon = 20;
        $this->ride1->gpsLat = 30;
        $this->ride1->distance = 100;
        $this->ride1->gear = Ride::GEAR_MTB;
        $this->ride1->beginning = new \DateTime();

        $this->ride2 = new Ride();
        $this->ride2->name = 'random ride';
        $this->ride2->locationDescription = 'over there';
        $this->ride2->gpsLon = 20;
        $this->ride2->gpsLat = 30;
        $this->ride2->distance = 100;
        $this->ride2->gear = Ride::GEAR_MTB;
        $this->ride2->beginning = new \DateTime();

    }

    public function testRepositoryWillSavePersistedObject()
    {
        $this->repository->add($this->ride1);

        $this->assertSame($this->ride1, $this->repository->get($this->ride1->getId()));
    }

    public function testRepositoryWillRemoveGivenObjectByGivenId()
    {
        $this->repository->add($this->ride1);

        $this->assertSame($this->ride1, $this->repository->get($this->ride1->getId()));

        $this->repository->remove($this->ride1->getId());
        $this->assertEquals(0, count($this->repository->findAll()));
    }

    public function testRepositoryWillReturnAllSavedRides()
    {
        $this->repository->add($this->ride1);
        $this->repository->add($this->ride2);

        $this->assertEquals(2, count($this->repository->findAll()));
    }

    public function testRepositoryCanRemoveAllSavedRides()
    {
        $this->repository->add($this->ride1);
        $this->repository->add($this->ride2);

        $this->assertEquals(2, count($this->repository->findAll()));
        $this->repository->removeAll();
        $this->assertEquals(0, count($this->repository->findAll()));
    }

    public function tearDown()
    {
        $this->repository->removeAll();
    }
}
