<?php
namespace tests\AppBundle\Service;

use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\User;
use AppBundle\Service\DrafterService;

class DrafterServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testIfPhpUnitWorks()
    {
        $this->assertTrue(true);
    }
    public function testServiceWillAddNewRideWithSpecifiedUserAsOwner() {
        $dto = new NewRideDto();
        $dto->user = new User();
        $dto->rideLocation = 'warszawa';
        $dto->rideBeginning = new \DateTime();

        $repositoryMock = $this->getMockBuilder('AppBundle\Repository\RideRepositoryInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $repositoryMock->expects($this->once())
            ->method('add')
            ->with($this->isInstanceOf('AppBundle\Entity\Ride'))
            ->will($this->returnValue(true));

        $drafterService = new DrafterService($repositoryMock);

        $this->assertTrue($drafterService->addRide($dto));
    }
    public function testServiceWillFailWhenRepositoryFails() {
        $dto = new NewRideDto();
        $dto->user = new User();
        $dto->rideLocation = 'warszawa';
        $dto->rideBeginning = new \DateTime();

        $repositoryMock = $this->getMockBuilder('AppBundle\Repository\RideRepositoryInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $repositoryMock->expects($this->once())
            ->method('add')
            ->with($this->isInstanceOf('AppBundle\Entity\Ride'))
            ->will($this->returnValue(false));

        $drafterService = new DrafterService($repositoryMock);

        $this->assertFalse($drafterService->addRide($dto));
    }
}
