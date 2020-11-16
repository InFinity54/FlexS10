<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Entity\Match;
use App\Entity\MatchComp;
use App\Entity\MatchStats;
use App\Entity\Player;
use App\Traits\MatchTrait;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchhistoryController extends AbstractController
{
    use MatchTrait;

    /**
     * @Route("/matchhistory", name="matchhistory")
     * @return Response
     */
    public function index()
    {
        return $this->render('matchhistory/index.html.twig', [
            "total" => [
                "matchs" => $this->getDoctrine()->getRepository(Match::class)->getNumberOfMatchs(),
                "victory" => $this->getDoctrine()->getRepository(Match::class)->getNumberOfVictory(),
                "defeat" => $this->getDoctrine()->getRepository(Match::class)->getNumberOfDefeat(),
                "remake" => $this->getDoctrine()->getRepository(Match::class)->getNumberOfRemake()
            ],
            "matchs" => $this->getDoctrine()->getRepository(Match::class)->findAllOrderedByDate(),
            "compos" => $this->getDoctrine()->getRepository(MatchComp::class)->findAll()
        ]);
    }


    /**
     * @Route("/matchhistory/add", name="addmatch")
     * @return Response
     */
    public function add()
    {
        return $this->render('matchhistory/add.html.twig', []);
    }


    /**
     * @Route("/matchhistory/save", name="savematch")
     * @return Response
     */
    public function save()
    {
        if ($_POST["sendtype"] === "single")
        {
            try
            {
                $this->saveMatch($this->getDoctrine()->getManager(), json_decode(file_get_contents("https://euw1.api.riotgames.com/lol/match/v4/matches/" . $_POST["matchid"] . "?api_key=" . $_ENV['RIOT_APIKEY']), true));
                $this->addFlash("success", "Le match N°".$_POST["matchid"]." a été correctement ajouté !");
            }
            catch (Exception $e)
            {
                $this->addFlash("error", "Une erreur est survenue lors de l'ajout du match N°".$_POST["matchid"]." : ".$e->getMessage());
                return $this->redirectToRoute("addmatch");
            }

            return $this->redirectToRoute("matchhistory");
        }

        if ($_POST["sendtype"] === "multiple")
        {
            try
            {
                for ($i = 0, $iMax = count($_FILES["matchfiles"]["tmp_name"]); $i < $iMax; $i++)
                {
                    $this->saveMatch($this->getDoctrine()->getManager(), json_decode(file_get_contents($_FILES["matchfiles"]["tmp_name"][$i]), true));
                    $this->addFlash("success", "Le match N°".str_replace(".json", "", $_FILES["matchfiles"]["name"][$i])." a été correctement ajouté !");
                }
            }
            catch (Exception $e)
            {
                $this->addFlash("error", "Une erreur est survenue lors de l'ajout des matchs : ".$e->getMessage());
                return $this->redirectToRoute("addmatch");
            }

            return $this->redirectToRoute("matchhistory");
        }

        $this->addFlash("error", "Aucune information n'a été reçue concernant la ou les parties à ajouter.");
        return $this->redirectToRoute("addmatch");
    }


    /**
     * @Route("/matchhistory/recreatedb", name="recreate_database")
     * @return Response
     */
    public function recreateDatabase()
    {
        try
        {
            $i = 0;
            $this->clearDatabase();
            $oldGames = $this->getAllPreviousFiles();

            foreach ($oldGames as $oldGame)
            {
                if (!$this->getDoctrine()->getRepository(Match::class)->find(str_replace(".json", "", $oldGame))) {
                    $json = json_decode(file_get_contents(realpath($this->appKernel->getProjectDir()."/files/games/".$oldGame)), true);
                    $this->saveMatch($this->getDoctrine()->getManager(), $json, true);
                }
                $i++;
            }

            $this->addFlash("success", "La base de données à été recréée. ".$i." partie(s) sur ".count($oldGames)." ont été réajoutés.");
            return $this->redirectToRoute("matchhistory");
        }
        catch (Exception $e)
        {
            $this->addFlash("error", "Une erreur est survenue durant la procédure. ".$e->getMessage());
            return $this->redirectToRoute("addmatch");
        }
    }

    private function clearDatabase()
    {
        $manager = $this->getDoctrine()->getManager();
        $champs = $manager->getRepository(Champion::class)->findAll();
        $matchs = $manager->getRepository(Match::class)->findAll();
        $matchCompos = $manager->getRepository(MatchComp::class)->findAll();
        $matchStats = $manager->getRepository(MatchStats::class)->findAll();

        foreach ($champs as $champ)
        {
            $manager->remove($champ);
        }

        foreach ($matchs as $match)
        {
            $manager->remove($match);
        }

        foreach ($matchCompos as $matchCompo)
        {
            $manager->remove($matchCompo);
        }

        foreach ($matchStats as $matchStat)
        {
            $manager->remove($matchStat);
        }

        $manager->flush();
    }

    private function getAllPreviousFiles()
    {
        return preg_grep('~\.(json)$~', scandir(realpath($this->appKernel->getProjectDir()."/files/games/")));
    }
}
