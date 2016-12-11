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
    public function authorizeAction()
    {
        return $this->templating->renderResponse('strava/authorize.html.twig');
    }

    /**
     * @return Response
     */
    public function returnAction()
    {
        $code = $_REQUEST['code'];
        $response = $this->stravaService->authorizeToken($code);
        $response = json_decode($response, true);
        $access_token = $response['access_token'];
        foreach ($response['athlete']['clubs'] as $club) {
            $this->stravaService->saveNewClub($club);
            $this->stravaService->importClubEvents($club['id'], $access_token);
        }
        return $this->templating->renderResponse('strava/return.html.twig');
    }
}
