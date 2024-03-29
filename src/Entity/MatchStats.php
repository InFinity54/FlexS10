<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchsStatsRepository")
 * @ORM\Table(name="`match_stats`")
 */
class MatchStats
{
    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Entity\Match")
     * @ORM\JoinColumn(nullable=false)
     */
    private $match;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Player")
     * @ORM\JoinColumn(name="player", referencedColumnName="nickname")
     */
    private $player;

    /**
     * @ORM\Column(type="integer")
     */
    private $kills;

    /**
     * @ORM\Column(type="integer")
     */
    private $deaths;

    /**
     * @ORM\Column(type="integer")
     */
    private $assists;

    /**
     * @ORM\Column(type="integer")
     */
    private $creeps;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalDamage;

    /**
     * @ORM\Column(type="integer")
     */
    private $physDamage;

    /**
     * @ORM\Column(type="integer")
     */
    private $magicDamage;

    /**
     * @ORM\Column(type="integer")
     */
    private $rawDamage;

    public function getMatch(): ?Match
    {
        return $this->match;
    }

    public function setMatch(Match $match): self
    {
        $this->match = $match;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getKills(): ?int
    {
        return $this->kills;
    }

    public function setKills(int $kills): self
    {
        $this->kills = $kills;

        return $this;
    }

    public function getDeaths(): ?int
    {
        return $this->deaths;
    }

    public function setDeaths(int $deaths): self
    {
        $this->deaths = $deaths;

        return $this;
    }

    public function getAssists(): ?int
    {
        return $this->assists;
    }

    public function setAssists(int $assists): self
    {
        $this->assists = $assists;

        return $this;
    }

    public function getCreeps(): ?int
    {
        return $this->creeps;
    }

    public function setCreeps(int $creeps): self
    {
        $this->creeps = $creeps;

        return $this;
    }

    public function getTotalDamage(): ?int
    {
        return $this->totalDamage;
    }

    public function setTotalDamage(int $totalDamage): self
    {
        $this->totalDamage = $totalDamage;

        return $this;
    }

    public function getPhysDamage(): ?int
    {
        return $this->physDamage;
    }

    public function setPhysDamage(int $physDamage): self
    {
        $this->physDamage = $physDamage;

        return $this;
    }

    public function getMagicDamage(): ?int
    {
        return $this->magicDamage;
    }

    public function setMagicDamage(int $magicDamage): self
    {
        $this->magicDamage = $magicDamage;

        return $this;
    }

    public function getRawDamage(): ?int
    {
        return $this->rawDamage;
    }

    public function setRawDamage(int $rawDamage): self
    {
        $this->rawDamage = $rawDamage;

        return $this;
    }
}
