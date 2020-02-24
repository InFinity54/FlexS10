<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchsRepository")
 */
class Matchs
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $result;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duration;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MatchsComp", mappedBy="MatchId", cascade={"persist", "remove"})
     */
    private $comp;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MatchsStats", mappedBy="MatchId", cascade={"persist", "remove"})
     */
    private $stats;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getComp(): ?MatchsComp
    {
        return $this->comp;
    }

    public function setComp(MatchsComp $comp): self
    {
        $this->comp = $comp;

        // set the owning side of the relation if necessary
        if ($comp->getMatchId() !== $this) {
            $comp->setMatchId($this);
        }

        return $this;
    }

    public function getStats(): ?MatchsStats
    {
        return $this->stats;
    }

    public function setStats(MatchsStats $stats): self
    {
        $this->stats = $stats;

        // set the owning side of the relation if necessary
        if ($stats->getMatchId() !== $this) {
            $stats->setMatchId($this);
        }

        return $this;
    }
}
