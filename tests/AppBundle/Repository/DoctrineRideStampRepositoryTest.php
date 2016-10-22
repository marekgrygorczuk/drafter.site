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

    /** @var  DatabaseRideRepository */
    private $repository;

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
    }

    public function testRepositoryWillSavePersistedObject()
    {
        $expectedRideStamp = new RideStamp();
        $expectedRideStamp->setDayOfWeekOccurrence(RideStamp::MONDAY);

        $this->repository->add($expectedRideStamp);

        $this->assertSame($expectedRideStamp, $this->repository->get($expectedRideStamp->getId()));
    }

    public function testRepositoryWillRemoveGivenObjectByGivenId()
    {
        $expectedRide = new Ride("warsaw", new \DateTime(),'test name');

        $this->repository->add($expectedRide);

        $this->assertSame($expectedRide, $this->repository->get($expectedRide->getId()));

        $this->repository->remove($expectedRide->getId());
        $this->assertEquals(0, count($this->repository->findAll()));
    }

    public function testRepositoryWillReturnAllSavedRides()
    {
        $ride1 = new Ride("warsaw", new \DateTime(), 'test name2');
        $ride2 = new Ride("warsaw", new \DateTime(), 'test name2');

        $this->repository->add($ride1);
        $this->repository->add($ride2);

        $this->assertEquals(2, count($this->repository->findAll()));
    }

    public function testRepositoryCanRemoveAllSavedRides()
    {
        $ride1 = new Ride("warsaw", new \DateTime(), 'test name2');
        $ride2 = new Ride("warsaw", new \DateTime(), 'test name2');

        $this->repository->add($ride1);
        $this->repository->add($ride2);

        $this->assertEquals(2, count($this->repository->findAll()));
        $this->repository->removeAll();
        $this->assertEquals(0, count($this->repository->findAll()));
    }

    public function tearDown()
    {
        $this->repository->removeAll();
    }
}
