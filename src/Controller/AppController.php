<?php
namespace App\Controller;

use App\Entity\Champion;
use App\Entity\Match;
use App\Entity\MatchComp;
use App\Entity\MatchStats;
use App\Entity\Player;
use App\Traits\ChampionTrait;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController
{
    use ChampionTrait;


    /**
     * @Route("/", name="homepage")
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