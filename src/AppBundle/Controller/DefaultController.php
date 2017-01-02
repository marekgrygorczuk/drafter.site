<?php

namespace AppBundle\Controller;

use AppBundle\Dto\RideFilters;
use AppBundle\Dto\RideListItem;
use AppBundle\Entity\RideStamp;
use AppBundle\Form\NewRideDtoType;
use AppBundle\Form\RideStampType;
use AppBundle\Service\DrafterService;
use AppBundle\Dto\NewRideDto;
use AppBundle\Service\GpsLocation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactory;
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
     * @var
     */
    private $stravaClientId;

    /**
     * DefaultController constructor.
     * @param DrafterService $drafterService
     * @param EngineInterface $templating
     * @param FormFactory $formFactory
     * @param $stravaClientId
     */
    public function __construct(DrafterService $drafterService, EngineInterface $templating, FormFactory $formFactory, $stravaClientId)
    {
        $this->drafterService = $drafterService;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->stravaClientId = $stravaClientId;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $cookies = $request->cookies;
        $filters = new RideFilters();
        if ($cookies->has('drafter_lat')) {
            $userGpsLocation = new GpsLocation($cookies->get('drafter_lat'), $cookies->get('drafter_lon'));
            $filters->maxDistanceFromUser = 500;
            $filters->latestDate = new \DateTime("+10 days");
            $filters->earliestDate = new \DateTime();
            $rideListItems = $this->drafterService->findFilteredRideItems($filters, $userGpsLocation);
        } else {
            $userGpsLocation = null;
            $rideListItems = [];
        }
        return $this->templating->renderResponse('default/index.html.twig', ['rides' => $rideListItems, 'userLocation' => $userGpsLocation, 'clientId' => $this->stravaClientId]);
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
