<?php

namespace App\Controller;

use App\Entity\TennisTour;
use App\Form\TennisTourType;
use App\Repository\TennisTourRepository;
use App\Repository\TennisTournoiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tours")
 */
class TennisTourController extends AbstractController
{
    /**
     * @Route("/tours-tournoi/{id}", name="tennis_tour_index", methods={"GET"})
     */
    public function index(TennisTourRepository $tennisTourRepository, TennisTournoiRepository $tennisTournoiRepository, $id): Response
    {
        return $this->render('tennis_tour/index.html.twig', [
            'tennis_tours' => $tennisTourRepository->findByTennisTournoi($id),
            'tournoi' => $tennisTournoiRepository->find($id)
        ]);
    }

    /**
     * @Route("/new/{id}", name="tennis_tour_new", methods={"GET","POST"})
     */
    public function new(Request $request, TennisTournoiRepository $tennisTournoiRepository, $id): Response
    {
        $tennisTour = new TennisTour();
        $tournoiAssocie = $tennisTournoiRepository->find($id);
        $form = $this->createForm(TennisTourType::class, $tennisTour);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $numeroTournoi = sizeof($tournoiAssocie->getTennisTours()) +1;
            
            // Définir le statut du tour
            $tennisTour->setStatut("Organisation");

            // Définir le statut du tour
            $tennisTour->setNumero($numeroTournoi);

            //Définir le tournoi associé au tour
            $tennisTour->setTennisTournoi($tournoiAssocie);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tennisTour);
            $entityManager->flush();
            
            $numeroTournoi ++;

            return $this->redirectToRoute('tennis_tour_index', [
                'id' => $tennisTour->getTennisTournoi()->getId() 
            ]);
        }

        return $this->render('tennis_tour/new.html.twig', [
            'tennis_tour' => $tennisTour,
            'tennis_tournoi' => $tournoiAssocie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_tour_show", methods={"GET"})
     */
    public function show(TennisTour $tennisTour): Response
    {
        return $this->render('tennis_tour/show.html.twig', [
            'tennis_tour' => $tennisTour
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_tour_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisTour $tennisTour): Response
    {
        $form = $this->createForm(TennisTourType::class, $tennisTour);
        $form->handleRequest($request);

        if ($form->isSubmitted()) { // && $form->isValid() 
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('tennis_tour_index', [
                'id' => $tennisTour->getTennisTournoi()->getId() 
            ]);
        }

        return $this->render('tennis_tour/edit.html.twig', [
            'tennis_tour' => $tennisTour,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_tour_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TennisTour $tennisTour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisTour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisTour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_tour_index');
    }
}
