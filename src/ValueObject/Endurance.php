<?php declare(strict_types=1);
namespace App\ValueObject;

final class Endurance
{
    /**
     * @var float
     */
    private $endurance;

    public static function create(float $endurance): self
    {
        if (0 > $endurance || 10 < $endurance) {
            throw new \RuntimeException(\sprintf('Endurance out of limit. "%f"', $endurance));
        }

        $self            = new self();
        $self->endurance = $endurance;

        return $self;
    }

    private function __construct()
    {
    }

    public function get(): float
    {
        return $this->endurance;
    }
}
