<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TennisTournoi;

class TournamenttennisController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('tournamenttennis/index.html.twig');
    }

    /**
     * @Route("/changer-mdp", name="changer_de_mot_passe")
     */
    public function changerDeMotDePasse()
    {
        return $this->render('tournamenttennis\changer_de_mot_passe.html.twig');
    }

}
