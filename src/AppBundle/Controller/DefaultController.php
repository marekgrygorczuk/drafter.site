<?php

namespace AppBundle\Controller;

use AppBundle\Service\DrafterService;
use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\User;
use AppBundle\Repository\MemoryRideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class DefaultController extends Controller
{
    /**
     * @var DrafterService
     */
    private $drafterService;
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * DefaultController constructor.
     * @param DrafterService $drafterService
     * @param EngineInterface $templating
     */
    public function __construct(DrafterService $drafterService, EngineInterface $templating)
    {
        $this->drafterService = $drafterService;
        $this->templating = $templating;
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
//        var_dump($allRides);
        return $this->templating->renderResponse('default/index.html.twig', [
            'rides' => $allRides,
            ]
        );
    }
}
