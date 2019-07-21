<?php declare(strict_types=1);
namespace App\Advancer;

use App\Entity\Horse;
use App\Entity\Race;

class RaceAdvancer
{
    /**
     * @var HorseAdvancer
     */
    private $horseAdvancer;

    public function __construct(HorseAdvancer $horseAdvancer)
    {
        $this->horseAdvancer = $horseAdvancer;
    }

    public function advance(Race $race): void
    {
        $raceFinished = \array_reduce(
            $race->getHorses()->toArray(),
            function (bool $raceFinished, Horse $horse): bool {
                return $this->horseAdvancer->advance($horse) && $raceFinished;
            },
            true
        );
        $race->setIsFinished($raceFinished);
    }
}
