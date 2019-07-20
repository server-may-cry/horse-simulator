<?php declare(strict_types=1);
namespace App\Entity;

use App\ValueObject\Endurance;
use App\ValueObject\Progress;
use App\ValueObject\Speed;
use App\ValueObject\Strength;
use App\ValueObject\Time;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HorseRepository")
 * @ORM\Table(indexes={
 *      @ORM\Index(name="search_fastest", columns={"progress", "time"})
 * })
 */
class Horse
{
    /**
     * @var null|int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Speed
     * @ORM\Column(type="speed")
     */
    private $speed;

    /**
     * @var Strength
     * @ORM\Column(type="strength")
     */
    private $strength;

    /**
     * @var Endurance
     * @ORM\Column(type="endurance")
     */
    private $endurance;

    /**
     * @var Progress
     * @ORM\Column(type="progress")
     */
    private $progress;

    /**
     * @var Time
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @var null|Race
     * @ORM\ManyToOne(targetEntity="App\Entity\Race", inversedBy="horses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpeed(): Speed
    {
        return $this->speed;
    }

    public function setSpeed(Speed $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getStrength(): Strength
    {
        return $this->strength;
    }

    public function setStrength(Strength $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getEndurance(): Endurance
    {
        return $this->endurance;
    }

    public function setEndurance(Endurance $endurance): self
    {
        $this->endurance = $endurance;

        return $this;
    }

    public function getProgress(): Progress
    {
        return $this->progress;
    }

    public function setProgress(Progress $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    public function getTime(): Time
    {
        return $this->time;
    }

    public function setTime(Time $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }
}
