<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchsCompRepository")
 */
class MatchsComp
{
    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Entity\Matchs", inversedBy="comp", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $matchId;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Players")
     * @ORM\JoinColumn(nullable=false)
     */
    private $playerNickname;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Champions")
     * @ORM\JoinColumn(name="championName", referencedColumnName="name")
     */
    private $championName;

    public function getMatchId(): ?Matchs
    {
        return $this->matchId;
    }

    public function setMatchId(Matchs $matchId): self
    {
        $this->matchId = $matchId;

        return $this;
    }

    public function getPlayerNickname(): ?Players
    {
        return $this->playerNickname;
    }

    public function setPlayerNickname(?Players $playerNickname): self
    {
        $this->playerNickname = $playerNickname;

        return $this;
    }

    public function getChampionName(): ?Champions
    {
        return $this->championName;
    }

    public function setChampionName(?Champions $championName): self
    {
        $this->championName = $championName;

        return $this;
    }
}
