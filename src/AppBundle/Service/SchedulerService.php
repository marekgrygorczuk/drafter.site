<?php
namespace AppBundle\Service;

use AppBundle\Entity\Ride;
use AppBundle\Entity\RideMint;
use AppBundle\Entity\RideStamp;
use AppBundle\Repository\RideRepositoryInterface;
use AppBundle\Repository\RideStampRepositoryInterface;

class SchedulerService
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

    public function scheduleRides($firstDay, $lastDay)
    {
        $scheduledRidesCounter = 0;
        $mint = new RideMint();
        $stamps = $this->rideStampRepository->findAll();

        /** @var RideStamp $stamp */
        foreach ($stamps as $stamp) {
            $rides = $mint->hammerRides($stamp, $firstDay, $lastDay);
            /** @var Ride $ride */
            foreach ($rides as $ride) {
                $this->rideRepository->add($ride);
                $scheduledRidesCounter++;
            }
        }
        return $scheduledRidesCounter;
    }

}