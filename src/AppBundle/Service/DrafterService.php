<?php
namespace AppBundle\Service;

use AppBundle\Dto\NewRideDto;
use AppBundle\Dto\RideListItem;
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

    /**
     * @param GpsLocation|null $location
     * @return RideListItem[]
     */
    public function findAllRidesWithDistances(GpsLocation $location = null) : array
    {
        $rides = $this->rideRepository->findUpcomingRides();
        $rideListItems = [];
        /** @var Ride $ride */
        foreach ($rides as $ride) {
            if (empty($location))
                $distance = null;
            else
                $distance = $this->rulerService->getDistance($location, new GpsLocation($ride->gpsLat, $ride->gpsLon));
            $rideListItem = new RideListItem();
            $rideListItem->id = $ride->id;
            $rideListItem->name = $ride->name;
            $rideListItem->locationDescription = $ride->locationDescription;
            $rideListItem->gpsLon = $ride->gpsLon;
            $rideListItem->gpsLat = $ride->gpsLat;
            $rideListItem->beginning = $ride->beginning;
            $rideListItem->distance = $ride->distance;
            $rideListItem->gear = $ride->gear;
            $rideListItem->distanceToUser = $distance;
            $rideListItems[] = $rideListItem; 
        }
        return $rideListItems;
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

    public function mintAllRidesForNext4Weeks()
    {
        $rideStamps = $this->rideStampRepository->findAll();
        foreach ($rideStamps as $rideStamp) {
            $rides = $this->rideMint->hammerRides($rideStamp, new \DateTime(), new \DateTime('+4 weeks'));
            foreach ($rides as $ride) {
                $this->rideRepository->add($ride);
            }
        }
    }
}