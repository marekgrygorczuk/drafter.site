<?php

namespace AppBundle\Controller;

use AppBundle\Service\StravaService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class StravaController extends Controller
{
    /**
     * @var StravaService
     */
    private $stravaService;
    /**
     * @var EngineInterface
     */
    private $templating;

    public function __construct(StravaService $stravaService, EngineInterface $templating)
    {
        $this->stravaService = $stravaService;
        $this->templating = $templating;
    }

    /**
     * @return Response
     */
    public function returnAction()
    {
        $this->stravaService->synchronizeUserWithStrava($_REQUEST['code']);
        return $this->templating->renderResponse('strava/return.html.twig');
    }
}
