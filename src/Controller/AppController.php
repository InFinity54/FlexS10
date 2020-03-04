<?php
namespace App\Controller;

use App\Entity\MatchComp;
use App\Entity\MatchStats;
use App\Traits\ChampionTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController
{
    use ChampionTrait;


    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index()
    {
        $playedChamps = $this->getDoctrine()->getRepository(MatchComp::class)->getPlayedChamps();
        $playedChampsLabels = [];
        $playedChampsValues = [];
        $playedChampsRecord = 0;

        if ($playedChamps)
        {
            foreach ($playedChamps as $playedChamp)
            {
                $playedChampsLabels[] = $playedChamp["champion"];
                $playedChampsValues[] = $playedChamp["number"];
                if (intval($playedChamp["number"]) > intval($playedChampsRecord))
                {
                    $playedChampsRecord = $playedChamp["number"];
                }
            }
        }

        return $this->render("index.html.twig", [
            "bestkills" => $this->getDoctrine()->getRepository(MatchStats::class)->getBestKills(),
            "bestdeaths" => $this->getDoctrine()->getRepository(MatchStats::class)->getBestDeaths(),
            "bestassists" => $this->getDoctrine()->getRepository(MatchStats::class)->getBestAssists(),
            "kdas" => $this->getDoctrine()->getRepository(MatchStats::class)->getKdas(),
            "playedchamps" => [
                "labels" => $playedChampsLabels,
                "values" => $playedChampsValues,
                "record" => $playedChampsRecord
            ]
        ]);
    }
}