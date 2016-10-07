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
    public function testRepositoryWillSavePersistedObject()
    {
        $expectedRide = new Ride(new User(), "warsaw", new \DateTime());

        $repository = new MemoryRideRepository();
        $repository->add($expectedRide);

        $this->assertSame($expectedRide, $repository->get($expectedRide->getId()));
    }
}
