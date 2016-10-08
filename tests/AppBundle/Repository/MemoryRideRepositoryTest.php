<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Ride;
use AppBundle\Entity\User;

class MemoryRideRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /** @var  MemoryRideRepository */
    private $repository;

    public function setUp() {
        $this->repository = new MemoryRideRepository();
    }
    public function testRepositoryWillSavePersistedObject()
    {
        $expectedRide = new Ride(new User(), "warsaw", new \DateTime());

        $this->repository->add($expectedRide);

        $this->assertSame($expectedRide, $this->repository->get($expectedRide->getId()));
    }

    public function testRepositoryWillRemoveGivenObjectByGivenId()
    {
        $expectedRide = new Ride(new User(), "warsaw", new \DateTime());

        $this->repository->add($expectedRide);

        $this->assertSame($expectedRide, $this->repository->get($expectedRide->getId()));

        $this->repository->remove($expectedRide->getId());
        $this->assertEquals(0, count($this->repository->findAll()));
    }

    public function testRepositoryWillReturnAllSavedRides()
    {
        $ride1 = new Ride(new User(), "warsaw", new \DateTime());
        $ride2 = new Ride(new User(), "warsaw", new \DateTime());

        $this->repository->add($ride1);
        $this->repository->add($ride2);

        $this->assertEquals(2, count($this->repository->findAll()));
    }
    public function testRepositoryCanRemoveAllSavedRides() {
        $ride1 = new Ride(new User(), "warsaw", new \DateTime());
        $ride2 = new Ride(new User(), "warsaw", new \DateTime());

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
