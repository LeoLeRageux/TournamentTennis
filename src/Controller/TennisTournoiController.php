<?php

namespace App\Controller;

use App\Entity\TennisTournoi;
use App\Form\TennisTournoiType;
use App\Form\TennisTournoiDateFin;
use App\Form\TennisTournoiDateDebut;
use App\Repository\TennisTournoiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tournois")
 */
class TennisTournoiController extends AbstractController
{
    /**
     * @Route("/", name="tennis_tournoi_index", methods={"GET"})
     */
    public function index(TennisTournoiRepository $tennisTournoiRepository): Response
    {
        return $this->render('tennis_tournoi/index.html.twig', [
            'tennis_tournois' => $tennisTournoiRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tennis_tournoi_new", methods={"POST","GET"})
     */
    public function new(Request $request): Response
    {
        $tennisTournoi = new TennisTournoi();
        $form = $this->createForm(TennisTournoiType::class, $tennisTournoi);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {

            //Définir le statut
            $tennisTournoi->setStatut("Non commencé");


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tennisTournoi);
            $entityManager->flush();

            return $this->redirectToRoute('tennis_tournoi_index');
       }

        return $this->render('tennis_tournoi/new.html.twig', [
            'tennis_tournoi' => $tennisTournoi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_tournoi_show", methods={"GET"})
     */
    public function show(TennisTournoi $tennisTournoi): Response
    {
        return $this->render('tennis_tournoi/show.html.twig', [
            'tennis_tournoi' => $tennisTournoi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_tournoi_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisTournoi $tennisTournoi): Response
    {
        $form = $this->createForm(TennisTournoiType::class, $tennisTournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted()) { //&& $form->isValid()
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_tournoi_index');
        }

        return $this->render('tennis_tournoi/edit.html.twig', [
            'tennis_tournoi' => $tennisTournoi,
            'form' => $form->createView()
        ]);
    }


	/**
     * @Route("/{id}/repousser-date-fin-tournoi", name="tennis_tournoi_repousser_date_fin", methods={"GET","POST"})
     */
    public function repousserDateFin(Request $request, TennisTournoi $tennisTournoi): Response
    {
        $ancienneDate = $tennisTournoi->getDateFinTournoi();
        $form = $this->createForm(TennisTournoiDateFin::class, $tennisTournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted()) { //&& $form->isValid()
            if($ancienneDate<$tennisTournoi->getDateFinTournoi()){
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('tennis_tour_index', ['id' => $tennisTournoi->getId()]);
            }
        }

        return $this->render('tennis_tournoi/repousserDate.html.twig', [
            'tennis_tournoi' => $tennisTournoi,
            'ancienne_date' => $ancienneDate,
            'form' => $form->createView()
        ]);
    }

    /**
       * @Route("/{id}/repousser-date-debut-tournoi", name="tennis_tournoi_repousser_date_deb", methods={"GET","POST"})
       */
      public function repousserDateDebut(Request $request, TennisTournoi $tennisTournoi): Response
      {
          $ancienneDate = $tennisTournoi->getDateDebutTournoi();
          $form = $this->createForm(TennisTournoiDateDebut::class, $tennisTournoi);
          $form->handleRequest($request);

          if ($form->isSubmitted()) { //&& $form->isValid()
              if($ancienneDate<$tennisTournoi->getDateDebutTournoi()){
                  $this->getDoctrine()->getManager()->flush();
                  return $this->redirectToRoute('tennis_tour_index', ['id' => $tennisTournoi->getId()]);
              }
          }

          return $this->render('tennis_tournoi/repousserDateDeb.html.twig', [
              'tennis_tournoi' => $tennisTournoi,
              'ancienne_date' => $ancienneDate,
              'form' => $form->createView()
          ]);
      }


    /**
     * @Route("/{id}", name="tennis_tournoi_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TennisTournoi $tennisTournoi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisTournoi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisTournoi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_tournoi_index');
    }

    /**
     * @Route("/supprimer/{id}", name="tennis_tournoi_supprimer")
     */
    public function supprimer(TennisTournoi $tennisTournoi){
        return $this->render('tennis_tournoi/supprimer.html.twig', [
            'tennis_tournoi' => $tennisTournoi,
        ]);
    }

    /**
     * @Route("/terminer/{id}", name="tennis_tournoi_terminer")
     */
    public function terminerTournoi(TennisTournoi $tennisTournoi): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $tennisTournoi->setStatut("Terminé");
        $entityManager->flush();
        return $this->redirectToRoute('tennis_tournoi_index');
    }

    /**
     * @Route("/rechercher-tournoi", name="tennis_tournoi_rechercher")
     */
    /* public function rechercher(TennisTournoiRepository $tennisTournoiRepository): Response
    {
        return $this->render('tennis_tournoi/rechercher.html.twig', [
            'tennis_tournois' => $tennisTournoiRepository->findAll(),
        ]);
    } */

	/**
     * @Route("/rechercher-tournoi/{id}", name="tennis_tournoi_afficher_tournoi_recherche")
     */
    public function afficherTournoiRecherche(TennisTournoi $tennisTournoi): Response
    {
        return $this->render('tennis_tournoi/afficherTournoiRecherche.html.twig', [
            'tennis_tournoi' => $tennisTournoi,
        ]);
    }
}
