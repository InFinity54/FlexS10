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

    protected function saveMatch(ObjectManager $manager, array $json, bool $isDatabaseRecreation = false)
    {
        $playerstosave = [];

        foreach ($manager->getRepository(Player::class)->findAll() as $player)
        {
            $playerstosave[] = $player->getNickname();
        }

        $match = $manager->getRepository(Match::class)->find($json["gameId"]);

        if (!$match) {
            $match = new Match();
            $match->setId($json["gameId"]);
            $match->setDateTime(((new DateTime(date("Y-m-d H:i:s", (int)$json["gameCreation"] / 1000))))->setTimezone(new DateTimeZone("Europe/Paris")));
            $match->setDuration(gmdate("i:s", $json["gameDuration"]));
        }

        foreach ($json["participantIdentities"] as $player)
        {
            if (in_array($player["player"]["summonerName"], $playerstosave))
            {
                $playertosave = $manager->getRepository(Player::class)->find($player["player"]["summonerName"]);
                $details = $json["participants"][$player["participantId"] - 1];
                $champion = $manager->getRepository(Champion::class)->find($this->getChampionName($details["championId"]));

                if ($match->getResult() === null) {
                    if ($details["stats"]["win"] === "Win") {
                        $match->setResult("WIN");
                    } else if ($details["stats"]["win"] === "Fail" && (int)$json["gameDuration"] > 300) {
                        $match->setResult("LOSE");
                    } else {
                        $match->setResult("REMAKE");
                    }
                }

                if (!$champion) {
                    $champion = new Champion();
                    $champion->setName($this->getChampionName($details["championId"]));
                    $champion->setDisplayName($this->getChampionDisplayName($details["championId"]));
                }


                $matchcomp = new MatchComp();
                $matchcomp->setPlayer($playertosave);
                $matchcomp->setChampion($champion);
                $matchcomp->setMatch($match);

                $matchstats = new MatchStats();
                $matchstats->setPlayer($playertosave);
                $matchstats->setKills($details["stats"]["kills"]);
                $matchstats->setDeaths($details["stats"]["deaths"]);
                $matchstats->setAssists($details["stats"]["assists"]);
                $matchstats->setCreeps((int)$details["stats"]["totalMinionsKilled"] + (int)$details["stats"]["neutralMinionsKilled"]);
                $matchstats->setTotalDamage($details["stats"]["totalDamageDealtToChampions"]);
                $matchstats->setPhysDamage($details["stats"]["physicalDamageDealtToChampions"]);
                $matchstats->setMagicDamage($details["stats"]["magicDamageDealtToChampions"]);
                $matchstats->setRawDamage($details["stats"]["trueDamageDealtToChampions"]);
                $matchstats->setMatch($match);

                $manager->persist($match);
                $manager->persist($champion);
                $manager->persist($matchcomp);
                $manager->persist($matchstats);

                $manager->flush();
            }
        }

        if (!$isDatabaseRecreation) {
            $this->saveMatchToServer($json);
        }
    }

    protected function saveMatchToServer(array $json)
    {
        file_put_contents(realpath($this->appKernel->getProjectDir()."/files/games/")."/".$json["gameId"].".json", json_encode($json));
    }
}