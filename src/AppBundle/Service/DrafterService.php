<?php
namespace AppBundle\Service;

use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\Ride;
use AppBundle\Entity\RideMint;
use AppBundle\Entity\RideStamp;
use AppBundle\Repository\RideRepositoryInterface;
use AppBundle\Repository\RideStampRepositoryInterface;

class DrafterService
{
    const scheduleHorizon = "+4 weeks";

    /**
     * @var RideRepositoryInterface
     */
    private $rideRepository;
    /**
     * @var RideStampRepositoryInterface
     */
    private $rideStampRepository;
    /**
     * @var RideMint
     */
    private $rideMint;
    /**
     * @var RulerService
     */
    private $rulerService;

    /**
     * DrafterService constructor.
     * @param RideRepositoryInterface $rideRepository
     * @param RideStampRepositoryInterface $rideStampRepository
     * @param RideMint $rideMint
     * @param RulerService $rulerService
     */
    public function __construct(RideRepositoryInterface $rideRepository,
                                RideStampRepositoryInterface $rideStampRepository,
                                RideMint $rideMint,
                                RulerService $rulerService)
    {
        $this->rideRepository = $rideRepository;
        $this->rideStampRepository = $rideStampRepository;
        $this->rideMint = $rideMint;
        $this->rulerService = $rulerService;
    }

    /**
     * @param NewRideDto $newRideDto
     * @return bool
     */
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
        return $this->rideRepository->findUpcomingRides();
    }

    public function findAllRidesWithDistances(GpsLocation $location) : array
    {
        $rides =  $this->rideRepository->findUpcomingRides();
        $distances = [];
        /** @var Ride $ride */
        foreach ($rides as $ride) {
            $distances[$ride->id] = $this->rulerService->getDistance($location, new GpsLocation($ride->gpsLat,$ride->gpsLon));
        }
        return ['rides' => $rides, 'distances' => $distances];
    }

    /**
     * @param RideStamp $rideStamp
     * @return bool
     */
    public function addRideStamp(RideStamp $rideStamp) : bool
    {
        if (!$this->rideStampRepository->add($rideStamp)) {
            return false;
        }

        $newRides = $this->rideMint->hammerRides($rideStamp, new \DateTime(), new \DateTime(self::scheduleHorizon));

        /** @var Ride $ride */
        foreach ($newRides as $ride) {
            $this->rideRepository->add($ride);
        }

        return true;
    }
}