<?php declare(strict_types=1);
namespace App\Controller;

use App\Repository\HorseRepository;
use App\Repository\RaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(
        HorseRepository $horseRepository,
        RaceRepository $raceRepository,
        FlashBagInterface $flashBag
    ): Response {
        return $this->render('index.html.twig', [
            //            'errors' => $flashBag->get('errors'),
            //            'oks' => $flashBag->get('oks'),
            'best_horse'        => $horseRepository->findFastestEverFinished(),
            'active_races'      => $raceRepository->findAllActive(),
            'finished_recently' => $raceRepository->findSeveralLastFinished(),
        ]);
    }
}
