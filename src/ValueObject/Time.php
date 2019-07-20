<?php declare(strict_types=1);
namespace App\ValueObject;

final class Time
{
    /**
     * @var float
     */
    private $time;

    /**
     * @param float $time It's not \DateInterval because of mutable nature.
     *                    $dateInterval = new DateInterval('PT59M');
     *                    $dateInterval->__construct('PT1M');
     */
    public static function create(float $time): self
    {
        if (0 > $time) {
            throw new \RuntimeException(\sprintf('Time out of limit. "%f"', $time));
        }

        $self       = new self();
        $self->time = $time;

        return $self;
    }

    private function __construct()
    {
    }

    public function get(): float
    {
        return $this->time;
    }
}
