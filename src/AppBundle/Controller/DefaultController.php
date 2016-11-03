<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ride;
use AppBundle\Entity\RideStamp;
use AppBundle\Form\NewRideDtoType;
use AppBundle\Form\RideStampType;
use AppBundle\Service\DrafterService;
use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $cookies = $request->cookies;

        if ($cookies->has('drafter_lat')) {
            var_dump($cookies->get('drafter_lat'));
            var_dump($cookies->get('drafter_lon'));

        }
        $allRides = $this->drafterService->AllRides();

        return $this->templating->renderResponse('default/index.html.twig', [
                'rides' => $allRides,
            ]
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addRideAction(Request $request)
    {
        $rideDto = new NewRideDto();
        $form = $this->formFactory->create(NewRideDtoType::class, $rideDto);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->drafterService->addRide($rideDto);
        }
        return $this->templating->renderResponse('default/addRide.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addRideStampAction(Request $request)
    {
        $rideStamp = new RideStamp();
        $form = $this->formFactory->create(RideStampType::class, $rideStamp);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->drafterService->addRideStamp($rideStamp);
        }
        return $this->templating->renderResponse('default/addRideStamp.html.twig', [
                'form' => $form->createView()
            ]
        );
    }
}
