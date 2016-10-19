<?php

namespace AppBundle\Controller;

use AppBundle\Service\DrafterService;
use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\User;
use AppBundle\Repository\MemoryRideRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @var DrafterService
     */
    private $drafterService;

    public function __construct(DrafterService $drafterService)
    {
        $this->drafterService = $drafterService;
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $dto = new NewRideDto();
        $dto->user = new User();
        $dto->rideLocation = 'warszawa';
        $dto->rideBeginning = new \DateTime();

        $this->drafterService->addRide($dto);

        $allRides = $this->drafterService->AllRides();
        var_dump($allRides);
        return $this->render('default/index.html.twig', [
            'rides' => $allRides,
            ]
        );
    }
}
