<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TournamenttennisController extends AbstractController
{
    /**
     * @Route("/tournamenttennis", name="tournamenttennis")
     */
    public function index()
    {
        return $this->render('tournamenttennis/index.html.twig', [
            'controller_name' => 'TournamenttennisController',
        ]);
    }
}
