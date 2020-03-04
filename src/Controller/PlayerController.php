<?php
namespace App\Controller;

use App\Entity\Match;
use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends AbstractController
{
    /**
     * @Route("/player/{id}", name="player")
     * @param string $id
     * @return Response
     */
    public function player(string $id)
    {
        return $this->render("player/index.html.twig", [
            "player" => $this->getDoctrine()->getRepository(Player::class)->find($id),
            "totalsavedgames" => $this->getDoctrine()->getRepository(Match::class)->getNumberOfMatchs(),
            "stats" => [
                "gamesnumber" => $this->getDoctrine()->getRepository(Player::class)->countNumberOfGames($id),
                "kda" => [
                    "total" => [
                        "kills" => $this->getDoctrine()->getRepository(Player::class)->countKills($id),
                        "deaths" => $this->getDoctrine()->getRepository(Player::class)->countDeaths($id),
                        "assists" => $this->getDoctrine()->getRepository(Player::class)->countAssists($id)
                    ],
                    "avg" => [
                        "kills" => number_format($this->getDoctrine()->getRepository(Player::class)->avgKills($id), 0, ",", " "),
                        "deaths" => number_format($this->getDoctrine()->getRepository(Player::class)->avgDeaths($id), 0, ",", " "),
                        "assists" => number_format($this->getDoctrine()->getRepository(Player::class)->avgAssists($id), 0, ",", " ")
                    ]
                ],
                "creeps" => [
                    "total" => $this->getDoctrine()->getRepository(Player::class)->countCreeps($id),
                    "avg" => number_format($this->getDoctrine()->getRepository(Player::class)->avgCreeps($id), 0, ",", " ")
                ],
                "dmg" => [
                    "total" => [
                        "number" => number_format($this->getDoctrine()->getRepository(Player::class)->countTotalDmg($id), 0, ",", " "),
                        "values" => [
                            number_format($this->getDoctrine()->getRepository(Player::class)->countTotalPhysDmg($id), 0, ",", ""),
                            number_format($this->getDoctrine()->getRepository(Player::class)->countTotalMagicDmg($id), 0, ",", ""),
                            number_format($this->getDoctrine()->getRepository(Player::class)->countTotalRawDmg($id), 0, ",", "")
                        ]
                    ],
                    "avg" => [
                        "number" => number_format($this->getDoctrine()->getRepository(Player::class)->avgDmg($id), 0, ",", " "),
                        "values" => [
                            number_format($this->getDoctrine()->getRepository(Player::class)->avgPhysDmg($id), 0, ",", ""),
                            number_format($this->getDoctrine()->getRepository(Player::class)->avgMagicDmg($id), 0, ",", ""),
                            number_format($this->getDoctrine()->getRepository(Player::class)->avgRawDmg($id), 0, ",", "")
                        ]
                    ],
                ]
            ]
        ]);
    }
}