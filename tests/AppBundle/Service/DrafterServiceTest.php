<?php
namespace tests\AppBundle\Service;

use AppBundle\Dto\NewRideDto;
use AppBundle\Dto\RideFilters;
use AppBundle\Dto\RideListItem;
use AppBundle\Entity\Ride;
use AppBundle\Entity\RideMint;
use AppBundle\Entity\RideStamp;
use AppBundle\Repository\RideRepositoryInterface;
use AppBundle\Repository\RideStampRepositoryInterface;
use AppBundle\Service\DrafterService;
use AppBundle\Service\RulerService;
use FilterService;

class DrafterServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var  RideRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $rideRepository;
    /** @var  RideStampRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $rideStampRepository;
    /** @var RideMint|\PHPUnit_Framework_MockObject_MockObject $mintMock */
    private $mintMock;
    /** @var  DrafterService */
    private $drafterService;
    /** @var  RulerService|\PHPUnit_Framework_MockObject_MockObject */
    private $rulerMock;
    /** @var  FilterService|\PHPUnit_Framework_MockObject_MockObject */
    private $filterMock;

    public function setUp()
    {

        $this->rideRepository = $this->getMockBuilder(RideRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rideStampRepository = $this->getMockBuilder(RideStampRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->mintMock = $this->getMockBuilder(RideMint::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->rulerMock = $this->getMockBuilder(RulerService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->filterMock = $this->getMockBuilder(FilterService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->drafterService = new DrafterService(
            $this->rideRepository,
            $this->rideStampRepository,
            $this->mintMock,
            $this->rulerMock,
            $this->filterMock);

    }

    public function testServiceWillAddNewRide()
    {
        $dto = new NewRideDto();
        $dto->rideLocation = 'warszawa';
        $dto->rideBeginning = new \DateTime();

        $this->rideRepository->expects($this->once())
            ->method('add')
            ->with($this->isInstanceOf(Ride::class))
            ->will($this->returnValue(true));

        $this->assertTrue($this->drafterService->addRide($dto));
    }

    public function testServiceWillAddNewRideStampAndCreateItsRidesForNextMonth()
    {
        $rideStamp = new RideStamp();
        $rideMock = $this->getMockBuilder(Ride::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mintMock->expects($this->once())
            ->method('hammerRides')
            ->with(
                $this->isInstanceOf(RideStamp::class),
                $this->isInstanceOf(\DateTime::class),
                $this->isInstanceOf(\DateTime::class)
            )
            ->will($this->returnValue([$rideMock]));

        $this->rideStampRepository->expects($this->once())
            ->method('add')
            ->with($this->isInstanceOf(RideStamp::class))
            ->will($this->returnValue(true));

        $this->rideRepository->expects($this->atLeastOnce())
            ->method('add')
            ->with($this->isInstanceOf(Ride::class))
            ->will($this->returnValue(true));

        $this->assertTrue($this->drafterService->addRideStamp($rideStamp));

    }

    public function testServiceWillFailWhenRepositoryFails()
    {
        $dto = new NewRideDto();
        $dto->rideLocation = 'warszawa';
        $dto->rideBeginning = new \DateTime();

        $this->rideRepository->expects($this->once())
            ->method('add')
            ->with($this->isInstanceOf('AppBundle\Entity\Ride'))
            ->will($this->returnValue(false));

        $this->assertFalse($this->drafterService->addRide($dto));
    }

    public function testServiceWillListAllRides()
    {
        $this->rideRepository->expects($this->once())
            ->method('findUpcomingRides')
            ->will($this->returnValue([]));

        $this->assertEquals([], $this->drafterService->findUpcomingRides());
    }
}
