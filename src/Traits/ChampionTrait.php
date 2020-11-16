<?php
namespace App\Traits;

Trait ChampionTrait
{
    protected function getChampionName($champid)
    {
        $json = json_decode(file_get_contents("https://leaguestats.infinity54.fr/riot/lol/latest/data/fr_FR/champion.json"), true);

        foreach ($json["data"] as $champ)
        {
            if ((int)$champid === (int)$champ["key"])
            {
                return $champ["id"];
            }
        }

        return null;
    }

    protected function getChampionDisplayName($champid)
    {
        $json = json_decode(file_get_contents("https://leaguestats.infinity54.fr/riot/lol/latest/data/fr_FR/champion.json"), true);

        foreach ($json["data"] as $champ)
        {
            if ((int)$champid === (int)$champ["key"])
            {
                return $champ["name"];
            }
        }

        return null;
    }
}