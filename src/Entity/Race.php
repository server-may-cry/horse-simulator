<?php declare(strict_types=1);
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RaceRepository")
 * @ORM\Table(indexes={
 *      @ORM\Index(name="check_active_limits", columns={"is_finished"})
 * })
 */
class Race
{
    /**
     * @var null|int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isFinished = false;

    /**
     * @var Collection|Horse[]
     * @ORM\OneToMany(targetEntity="App\Entity\Horse", mappedBy="race", orphanRemoval=true, cascade={"persist"})
     */
    private $horses;

    public function __construct()
    {
        $this->horses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsFinished(): bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    /**
     * Sorting in DQL not working for me on relations in case of join.
     *
     * @return Horse[]
     */
    public function getSortedHorses(): array
    {
        $iterator = $this->horses->getIterator();

        if (!$iterator instanceof \ArrayIterator) {
            throw new \RuntimeException();
        }

        $iterator->uasort(static function (Horse $horse1, Horse $horse2) {
            $distance = $horse2->getProgress()->get() <=> $horse1->getProgress()->get();

            if (0 !== $distance) {
                return $distance;
            }

            return $horse1->getTime()->get() <=> $horse2->getTime()->get();
        });

        return \iterator_to_array($iterator);
    }

    /**
     * @return Collection|Horse[]
     */
    public function getHorses(): Collection
    {
        return $this->horses;
    }

    public function addHorse(Horse $horse): self
    {
        if (!$this->horses->contains($horse)) {
            $this->horses[] = $horse;
            $horse->setRace($this);
        }

        return $this;
    }

    public function removeHorse(Horse $horse): self
    {
        if ($this->horses->contains($horse)) {
            $this->horses->removeElement($horse);
            // set the owning side to null (unless already changed)
            if ($horse->getRace() === $this) {
                $horse->setRace(null);
            }
        }

        return $this;
    }
}
