<?php

namespace App\Controller;

use App\Entity\Match;
use App\Entity\MatchComp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchhistoryController extends AbstractController
{
    /**
     * @Route("/matchhistory", name="matchhistory")
     */
    public function index()
    {
        $matchs = $this->getDoctrine()->getRepository(Match::class)->findAll();
        $compos = $this->getDoctrine()->getRepository(MatchComp::class)->findAll();

        return $this->render('matchhistory/index.html.twig', [
            "matchs" => $matchs,
            "compos" => $compos
        ]);
    }
}
