<?php
namespace tests\AppBundle\Service;

use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\User;
use AppBundle\Repository\RideRepositoryInterface;
use AppBundle\Repository\RideStampRepositoryInterface;
use AppBundle\Service\DrafterService;

class DrafterServiceTest extends \PHPUnit_Framework_TestCase
{
    private $rideRepository;
    private $rideStampRepository;
    private $drafterService;

    public function setUp() {

        $this->rideRepository = $this->getMockBuilder(RideRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rideStampRepository = $this->getMockBuilder(RideStampRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->drafterService = new DrafterService($this->rideRepository, $this->rideStampRepository);

    }
    public function testServiceWillAddNewRideWithSpecifiedUserAsOwner() {
        $dto = new NewRideDto();
        $dto->user = new User();
        $dto->rideLocation = 'warszawa';
        $dto->rideBeginning = new \DateTime();

        $this->rideRepositoryk->expects($this->once())
            ->method('add')
            ->with($this->isInstanceOf('AppBundle\Entity\Ride'))
            ->will($this->returnValue(true));

        $this->assertTrue($this->drafterService->addRide($dto));
    }
    public function testServiceWillFailWhenRepositoryFails() {
        $dto = new NewRideDto();
        $dto->user = new User();
        $dto->rideLocation = 'warszawa';
        $dto->rideBeginning = new \DateTime();

        $this->rideRepository->expects($this->once())
            ->method('add')
            ->with($this->isInstanceOf('AppBundle\Entity\Ride'))
            ->will($this->returnValue(false));

        $this->assertFalse($this->drafterService->addRide($dto));
    }
    public function testServiceWillListAllRides() {
        $this->rideRepository->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue([]));

        $this->assertEquals([], $this->drafterService->AllRides());
    }
}
