<?php
namespace AppBundle\Service;

use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\Ride;
use AppBundle\Repository\MemoryRideRepository;
use AppBundle\Repository\RideRepositoryInterface;

class DrafterService
{
    /**
     * @var RideRepositoryInterface
     */
    private $rideRepository;

    public function __construct(RideRepositoryInterface $rideRepository)
    {
        $this->rideRepository = $rideRepository;
    }

    public function addRide(NewRideDto $newRideDto) : bool
    {
        $ride = new Ride($newRideDto->user, $newRideDto->rideLocation, $newRideDto->rideBeginning);
        if (!$this->rideRepository->add($ride)) {
            return false;
        }
        return true;
    }

    public function AllRides() : array
    {
        return $this->rideRepository->findAll();
    }
}