<?php declare(strict_types=1);
namespace App\Generator;

use App\Entity\Race;

class RaceGenerator
{
    /**
     * @var RandomHorseGenerator
     */
    private $randomHorseGenerator;

    public function __construct(RandomHorseGenerator $randomHorseGenerator)
    {
        $this->randomHorseGenerator = $randomHorseGenerator;
    }

    public function create(): Race
    {
        $race = new Race();

        for ($i = 0; $i < 8; ++$i) {
            $race->addHorse($this->randomHorseGenerator->create());
        }

        return $race;
    }
}
