<?php
namespace App\Traits;

Trait ChampionTrait
{
    protected function getChampionName($champid)
    {
        $json = json_decode(file_get_contents("https://leaguestats.infinity54.fr/riot/latest/data/fr_FR/champion.json"));

        foreach ($json->data as $champ)
        {
            if (intval($champid) === intval($champ->key))
            {
                if ($champ->id === "Fiddlesticks")
                {
                    return "FiddleSticks";
                }
                else
                {
                    return $champ->id;
                }
            }
        }

        return null;
    }

    protected function getChampionDisplayName($champid)
    {
        $json = json_decode(file_get_contents("https://leaguestats.infinity54.fr/riot/latest/data/fr_FR/champion.json"));

        foreach ($json->data as $champ)
        {
            if (intval($champid) === intval($champ->key))
            {
                if ($champ->name === "Fiddlesticks")
                {
                    return "FiddleSticks";
                }
                else
                {
                    return $champ->name;
                }
            }
        }

        return null;
    }
}