<?php declare(strict_types=1);
namespace App\Advancer;

use App\Entity\Horse;
use App\ValueObject\Progress;
use App\ValueObject\Time;

class HorseAdvancer
{
    private const BASE_SPEED = 5.0;

    private const JOCKEY_SLOW_DOWN = 5.0;

    private const STRENGTH_MULTIPLIER = 8;

    private const ADVANCE_BY_AMOUNT_OF_SECONDS = 10.0;

    private const ENDURANCE_MULTIPLIER = 100.0;

    private const RACE_TOTAL_DISTANCE = 1500.0;

    public function advance(Horse $horse): bool
    {
        if ($this->isFinished($horse)) {
            return true;
        }

        $timeLeftInIteration     = self::ADVANCE_BY_AMOUNT_OF_SECONDS;
        $distanceWithoutSlowDown = $horse->getEndurance()->get() * self::ENDURANCE_MULTIPLIER;
        $freeDistanceLeft        = $distanceWithoutSlowDown - $horse->getProgress()->get();
        $horseBestSpeed          = $this->getBestSpeed($horse);

        if (0 < $freeDistanceLeft) {
            $timeToPassFreeDistance = $freeDistanceLeft / $horseBestSpeed;

            if (self::ADVANCE_BY_AMOUNT_OF_SECONDS < $timeToPassFreeDistance) {
                $this->advanceWithTime(
                    $horse,
                    $horseBestSpeed,
                    self::ADVANCE_BY_AMOUNT_OF_SECONDS
                );

                return $this->isFinished($horse);
            }
            $freeDistanceWillBePassInSeconds = $freeDistanceLeft / $horseBestSpeed;
            $timeLeftInIteration -= $freeDistanceWillBePassInSeconds;
            $this->advanceWithTime(
                $horse,
                $horseBestSpeed,
                $freeDistanceWillBePassInSeconds
            );
        }

        $slowedSpeed                 = $this->getSlowedSpeed($horse);
        $raceWillBeFinishedInSeconds = (self::RACE_TOTAL_DISTANCE - $horse->getProgress()->get()) / $slowedSpeed;
        $this->advanceWithTime(
            $horse,
            $slowedSpeed,
            \min($timeLeftInIteration, $raceWillBeFinishedInSeconds)
        );

        return $this->isFinished($horse);
    }

    private function advanceWithTime(Horse $horse, float $speed, float $time): void
    {
//        if ($time != 10) {
//            throw new \RuntimeException('time '.$time);
//        }
        $horse
            ->setProgress(Progress::create($horse->getProgress()->get() + $speed * $time))
            ->setTime(Time::create($horse->getTime()->get() + $time));
    }

    private function getBestSpeed(Horse $horse): float
    {
        return self::BASE_SPEED + $horse->getSpeed()->get();
    }

    private function getSlowedSpeed(Horse $horse): float
    {
        return $this->getBestSpeed($horse) - (
            self::JOCKEY_SLOW_DOWN / 100 * (100 - $horse->getStrength()->get() * self::STRENGTH_MULTIPLIER)
        );
    }

    private function isFinished(Horse $horse): bool
    {
        return self::RACE_TOTAL_DISTANCE === $horse->getProgress()->get();
    }
}
