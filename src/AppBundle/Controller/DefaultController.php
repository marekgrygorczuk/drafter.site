<?php

namespace AppBundle\Controller;

use AppBundle\Form\NewRideDtoType;
use AppBundle\Service\DrafterService;
use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactory;
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
     * @var FormFactory
     */
    private $formFactory;

    /**
     * DefaultController constructor.
     * @param DrafterService $drafterService
     * @param EngineInterface $templating
     * @param FormFactory $formFactory
     */
    public function __construct(DrafterService $drafterService, EngineInterface $templating, FormFactory $formFactory)
    {
        $this->drafterService = $drafterService;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
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
        return $this->templating->renderResponse('default/index.html.twig', [
            'rides' => $allRides,
            ]
        );
    }
    public function addRideAction() {
        $rideDto = new NewRideDto();
        $form = $this->formFactory->create(NewRideDtoType::class, $rideDto);
        return $this->templating->renderResponse('default/addRide.html.twig', [
                'form' => $form->createView()
            ]
        );
    }
}
