<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchsCompRepository")
 * @ORM\Table(name="`match_comp`")
 */
class MatchComp
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
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Champion")
     * @ORM\JoinColumn(name="champion", referencedColumnName="name")
     */
    private $champion;

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

    public function getChampion(): ?Champion
    {
        return $this->champion;
    }

    public function setChampion(?Champion $champion): self
    {
        $this->champion = $champion;

        return $this;
    }
}
