<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TennisTournoi;

class TournamenttennisController extends AbstractController
{
    

    /**
     * @Route("/changer-mdp", name="changer_de_mot_passe")
     */
    public function changerDeMotDePasse()
    {
        return $this->render('tournamenttennis\changer_de_mot_passe.html.twig');
    }

    /**
     * @Route("/nouvelle-date", name="set_date")
     */
    public function demandeDate()
    {
        return $this->render('tournamenttennis\changement_de_date.html.twig');
    }

    /**
     * @Route("/creer-compte", name="creation_compte")
     */
    public function creerCompte()
    {
        return $this->render('tournamenttennis/creer_compte.html.twig');
    }

}
