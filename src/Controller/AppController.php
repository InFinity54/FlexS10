<?php
namespace App\Controller;

use App\Entity\Champion;
use App\Entity\Match;
use App\Entity\MatchComp;
use App\Entity\MatchStats;
use App\Entity\Player;
use App\Traits\ChampionsTrait;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController
{
    use ChampionsTrait;


    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $bestKills = $this->getDoctrine()->getRepository(MatchStats::class)->getBestKills();
        $bestDeaths = $this->getDoctrine()->getRepository(MatchStats::class)->getBestDeaths();
        $bestAssists = $this->getDoctrine()->getRepository(MatchStats::class)->getBestAssists();
        $kdas = $this->getDoctrine()->getRepository(MatchStats::class)->getKdas();
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
            "bestkills" => $bestKills,
            "bestdeaths" => $bestDeaths,
            "bestassists" => $bestAssists,
            "kdas" => $kdas,
            "playedchamps" => [
                "labels" => $playedChampsLabels,
                "values" => $playedChampsValues,
                "record" => $playedChampsRecord
            ]
        ]);
    }


    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $json = json_decode(file_get_contents("C:\\laragon\\www\\flexs10\\public\\games\\4381384801.json"));
        $matchid = "4381384801";
        $playerstosave = [];

        $playerCoco = new Player();
        $playerCoco->setNickname("InFinity54");
        $playerCoco->setName("Coco");
        $entityManager->merge($playerCoco);

        $playerAxel = new Player();
        $playerAxel->setNickname("TheTøxine");
        $playerAxel->setName("Axel");
        $entityManager->merge($playerAxel);

        $playerKarl = new Player();
        $playerKarl->setNickname("nekkiro");
        $playerKarl->setName("Karl");
        $entityManager->merge($playerKarl);

        $playerChris = new Player();
        $playerChris->setNickname("Xevort");
        $playerChris->setName("Chris");
        $entityManager->merge($playerChris);

        $playerKoroko = new Player();
        $playerKoroko->setNickname("Kørøkø");
        $playerKoroko->setName("Koroko");
        $entityManager->merge($playerKoroko);

        $entityManager->flush();

        foreach ($entityManager->getRepository(Player::class)->findAll() as $player)
        {
            $playerstosave[] = $player->getNickname();
        }

        $date = new DateTime(date("Y-m-d H:i:s", substr($json->gameCreation, 0, strlen($json->gameCreation) - 3)), new DateTimeZone("Europe/Paris"));
        $matchresult = "";
        $matchduration = intdiv(intval($json->gameDuration), 60).":".(intval($json->gameDuration) % 60);

        foreach ($json->participantIdentities as $player)
        {
            if (in_array($player->player->summonerName, $playerstosave))
            {
                $playertosave = $entityManager->getRepository(Player::class)->find($player->player->summonerName);
                $details = $json->participants[$player->participantId - 1];

                if ($matchresult === "")
                {
                    if ($details->stats->win === false)
                    {
                        $matchresult = "LOSE";
                    }
                    else if ($details->stats->win === true)
                    {
                        $matchresult = "WIN";
                    }
                    else
                    {
                        $matchresult = "UNKNOWN";
                    }
                }

                $championdetails = [
                    "name" => $this->getChampionName($details->championId),
                    "displayname" => $this->getChampionDisplayName($details->championId)
                ];

                $kda = [
                    "kills" => $details->stats->kills,
                    "deaths" => $details->stats->deaths,
                    "assists" => $details->stats->assists
                ];

                $stats = [
                    "creeps" => intval($details->stats->totalMinionsKilled) + intval($details->stats->neutralMinionsKilled),
                    "totaldmg" => $details->stats->totalDamageDealtToChampions,
                    "physdmg" => $details->stats->physicalDamageDealtToChampions,
                    "magdmg" => $details->stats->magicDamageDealtToChampions,
                    "rawdmg" => $details->stats->trueDamageDealtToChampions
                ];

                $champion = new Champion();
                $champion->setName($championdetails["name"]);
                $champion->setDisplayName($championdetails["displayname"]);
                $entityManager->merge($champion);

                $match = new Match();
                $match->setId($matchid);
                $match->setDateTime($date);
                $match->setDuration($matchduration);
                $match->setResult($matchresult);
                $entityManager->merge($match);

                $matchcomp = new MatchComp();
                $matchcomp->setPlayer($playertosave);
                $matchcomp->setChampion($champion);
                $matchcomp->setMatch($match);
                $entityManager->merge($matchcomp);

                $matchstats = new MatchStats();
                $matchstats->setPlayer($playertosave);
                $matchstats->setKills($kda["kills"]);
                $matchstats->setDeaths($kda["deaths"]);
                $matchstats->setAssists($kda["assists"]);
                $matchstats->setCreeps($stats["creeps"]);
                $matchstats->setTotalDamage($stats["totaldmg"]);
                $matchstats->setPhysDamage($stats["physdmg"]);
                $matchstats->setMagicDamage($stats["magdmg"]);
                $matchstats->setRawDamage($stats["rawdmg"]);
                $matchstats->setMatch($match);
                $entityManager->merge($matchstats);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute("homepage");
    }
}