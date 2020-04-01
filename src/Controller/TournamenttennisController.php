<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TennisTournoi;

class TournamenttennisController extends AbstractController
{




    /**
     * @Route("/changer-", name="changer_de_mot_passe")
     */
    public function envoyerMail()
    {
      $message = (new \Swift_Message('Nouveau contact'))
        // On attribue l'expéditeur
        ->setFrom($contact['email'])

        // On attribue le destinataire
        ->setTo('votre@adresse.fr')

        // On crée le texte avec la vue
        ->setBody(
            $this->renderView(
                'emails/contact.html.twig', compact('contact')
            ),
            'text/html'
        )
    ;

        return $this->render('tournamenttennis\changer_de_mot_passe.html.twig');
    }

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

}
