<?php declare(strict_types=1);
namespace App\Controller;

use App\Advancer\RaceAdvancer;
use App\Entity\Race;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

final class AdvanceController extends AbstractController
{
    /**
     * @Route("/advance", name="advance")
     */
    public function advance(
        FlashBagInterface $flashBag,
        RaceAdvancer $raceAdvancer,
        RaceRepository $raceRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $activeRaces = $raceRepository->findAllActive();

        if (0 === \count($activeRaces)) {
            $flashBag->add('errors', 'There is no active races to advance');

            return $this->redirectToRoute('index');
        }

        \array_map(
            static function (Race $race) use ($raceAdvancer): void {
                $raceAdvancer->advance($race);
            },
            $activeRaces
        );
        $entityManager->flush();

        $flashBag->add('oks', 'All active races advanced');

        return $this->redirectToRoute('index');
    }
}
