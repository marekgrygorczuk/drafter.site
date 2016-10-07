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
        $dto->rideStart = new \DateTime();

        $drafterService = new DrafterService();

        $this->assertTrue($drafterService->addRide($dto));
    }
}
