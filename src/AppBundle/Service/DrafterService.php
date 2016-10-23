<?php
namespace AppBundle\Service;

use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\Ride;
use AppBundle\Repository\RideRepositoryInterface;
use AppBundle\Repository\RideStampRepositoryInterface;

class DrafterService
{
    /**
     * @var RideRepositoryInterface
     */
    private $rideRepository;
    /**
     * @var RideStampRepositoryInterface
     */
    private $rideStampRepository;

    public function __construct(RideRepositoryInterface $rideRepository,
                                RideStampRepositoryInterface $rideStampRepository)
    {
        $this->rideRepository = $rideRepository;
        $this->rideStampRepository = $rideStampRepository;
    }

    public function addRide(NewRideDto $newRideDto) : bool
    {
        $ride = new Ride($newRideDto->rideLocation, $newRideDto->rideBeginning, $newRideDto->name);
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