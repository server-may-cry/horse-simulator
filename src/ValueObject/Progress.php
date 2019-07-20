<?php declare(strict_types=1);
namespace App\ValueObject;

final class Progress
{
    /**
     * @var float
     */
    private $progress;

    public static function create(float $progress): self
    {
        if (0 > $progress || 1500 < $progress) {
            throw new \RuntimeException(\sprintf('Progress out of limit. "%f"', $progress));
        }

        $self           = new self();
        $self->progress = $progress;

        return $self;
    }

    private function __construct()
    {
    }

    public function get(): float
    {
        return $this->progress;
    }
}
