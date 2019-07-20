<?php declare(strict_types=1);
namespace App\ValueObject;

final class Speed
{
    /**
     * @var float
     */
    private $speed;

    public static function create(float $speed): self
    {
        if (0 > $speed || 10 < $speed) {
            throw new \RuntimeException(\sprintf('Speed out of limit. "%f"', $speed));
        }

        $self        = new self();
        $self->speed = $speed;

        return $self;
    }

    private function __construct()
    {
    }

    public function get(): float
    {
        return $this->speed;
    }
}
