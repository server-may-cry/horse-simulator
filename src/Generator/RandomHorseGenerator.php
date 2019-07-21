<?php declare(strict_types=1);
namespace App\Generator;

use App\Entity\Horse;
use App\ValueObject\Endurance;
use App\ValueObject\Progress;
use App\ValueObject\Speed;
use App\ValueObject\Strength;
use App\ValueObject\Time;

class RandomHorseGenerator
{
    public function create(): Horse
    {
        $horse = new Horse();
        $horse
            ->setEndurance(Endurance::create($this->createRandomFloatInRangeZeroToTen()))
            ->setStrength(Strength::create($this->createRandomFloatInRangeZeroToTen()))
            ->setSpeed(Speed::create($this->createRandomFloatInRangeZeroToTen()))
            ->setProgress(Progress::create(0))
            ->setTime(Time::create(0));

        return $horse;
    }

    private function createRandomFloatInRangeZeroToTen(): float
    {
        return \lcg_value() * 10;
    }
}
