<?php
namespace App\Traits;

Trait ChampionsTrait
{
    protected function getChampionName($champid)
    {
        $json = json_decode(file_get_contents("https://leaguestats.infinity54.fr/riot/latest/data/fr_FR/champion.json"));

        foreach ($json->data as $champ)
        {
            if (intval($champid) === intval($champ->key))
            {
                return $champ->id;
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
                return $champ->name;
            }
        }

        return null;
    }
}