<?php

namespace App\Controller;

use App\Entity\Match;
use App\Entity\MatchComp;
use App\Traits\MatchTrait;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchhistoryController extends AbstractController
{
    use MatchTrait;


    /**
     * @Route("/matchhistory", name="matchhistory")
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
     */
    public function add()
    {
        return $this->render('matchhistory/add.html.twig', []);
    }


    /**
     * @Route("/matchhistory/save", name="savematch")
     */
    public function save()
    {
        if ($_POST["sendtype"] === "single")
        {
            try
            {
                $this->saveMatch($this->getDoctrine()->getManager(), file_get_contents("https://euw1.api.riotgames.com/lol/match/v4/matches/".$_POST["matchid"]."?api_key=".$_ENV['RIOT_APIKEY']));
                $this->addFlash("success", "Le match N°".$_POST["matchid"]." a été correctement ajouté !");
            }
            catch (Exception $e)
            {
                $this->addFlash("error", "Une erreur est survenue lors de l'ajout du match N°".$_POST["matchid"]." : ".$e->getMessage());
                return $this->redirectToRoute("addmatch");
            }

            return $this->redirectToRoute("matchhistory");
        }
        else if ($_POST["sendtype"] === "multiple")
        {
            try
            {
                for ($i = 0; $i < count($_FILES["matchfiles"]["tmp_name"]); $i++)
                {
                    $this->saveMatch($this->getDoctrine()->getManager(), file_get_contents($_FILES["matchfiles"]["tmp_name"][$i]));
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
        else
        {
            $this->addFlash("error", "Aucune information n'a été reçue concernant la ou les parties à ajouter.");
            return $this->redirectToRoute("addmatch");
        }
    }
}
