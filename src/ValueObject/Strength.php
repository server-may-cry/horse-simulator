<?php declare(strict_types=1);
namespace App\ValueObject;

final class Strength
{
    /**
     * @var float
     */
    private $strength;

    public static function create(float $strength): self
    {
        if (0 > $strength || 10 < $strength) {
            throw new \RuntimeException(\sprintf('Strength out of limit. "%f"', $strength));
        }

        $self           = new self();
        $self->strength = $strength;

        return $self;
    }

    private function __construct()
    {
    }

    public function get(): float
    {
        return $this->strength;
    }
}
