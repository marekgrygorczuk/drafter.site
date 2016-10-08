<?php

namespace AppBundle\Controller;

use AppBundle\Dto\NewRideDto;
use AppBundle\Entity\User;
use AppBundle\Repository\DatabaseRideRepository;
use AppBundle\Repository\MemoryRideRepository;
use AppBundle\Service\DrafterService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $dto = new NewRideDto();
        $dto->user = new User();
        $dto->rideLocation = 'warszawa';
        $dto->rideBeginning = new \DateTime();

        $drafterService = new DrafterService(new MemoryRideRepository());
        $drafterService->addRide($dto);

        $allRides = json_encode($drafterService->AllRides());


        return new Response(
            '<html><body>
            <h1>Drafter</h1>
            <p>'.$allRides.'</p>
            </body></html>'

        );


//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
//        ]);
    }
}
