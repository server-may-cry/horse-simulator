<?php declare(strict_types=1);
namespace App\Controller;

use App\Generator\RaceGenerator;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

final class CreateController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     */
    public function create(
        RaceRepository $raceRepository,
        FlashBagInterface $flashBag,
        RaceGenerator $raceGenerator,
        EntityManagerInterface $entityManager
    ): Response {
        $activeRaces = $raceRepository->findAmountOfActive();

        if (3 === $activeRaces) {
            $flashBag->add('errors', 'Up to 3 races are allowed at the same time');

            return $this->redirectToRoute('index');
        }

        $race = $raceGenerator->create();

        $entityManager->persist($race);
        $entityManager->flush();

        $flashBag->add('oks', 'New race created');

        return $this->redirectToRoute('index');
    }
}
