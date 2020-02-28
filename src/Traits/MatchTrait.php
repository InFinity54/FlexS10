<?php
namespace App\Traits;

use App\Entity\Champion;
use App\Entity\Match;
use App\Entity\MatchComp;
use App\Entity\MatchStats;
use App\Entity\Player;
use DateTime;
use DateTimeZone;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

Trait MatchTrait
{
    use ChampionTrait;
    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    protected function saveMatch(ObjectManager $entityManager, string $jsonString)
    {
        $json = json_decode($jsonString);
        foreach ($entityManager->getRepository(Player::class)->findAll() as $player)
        {
            $playerstosave[] = $player->getNickname();
        }

        $date = new DateTime(date("Y-m-d H:i:s", substr($json->gameCreation, 0, strlen($json->gameCreation) - 3)), new DateTimeZone("Europe/Paris"));
        $matchid = $json->gameId;
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

        $this->saveMatchToServer($jsonString, $matchid);
    }

    protected function saveMatchToServer(string $jsonString, string $matchid)
    {
        file_put_contents(realpath($this->appKernel->getProjectDir()."/files/games/")."/".$matchid.".json", $jsonString);
    }
}