<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 07.10.16
 * Time: 23:47
 */

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
        $this->assertNull($this->repository->get($expectedRide->getId()));
    }

    public function testRepositoryWillReturnAllSavedRides()
    {
        $ride1 = new Ride(new User(), "warsaw", new \DateTime());
        $ride2 = new Ride(new User(), "warsaw", new \DateTime());

        $this->repository->add($ride1);
        $this->repository->add($ride2);

        $this->assertEquals(2, count($this->repository->findAll()));
    }
}
