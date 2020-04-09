<?php

namespace App\Controller;

use App\Entity\TennisTour;
use App\Form\TennisTourDateFinType;
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
            $tourExiteDeja = false;
            if($tennisTour->getType() != "Intermediaire"){
              foreach($tournoiAssocie->getTennisTours() as $tour){
                if($tennisTour->getType() == $tour->getType()){ // le tour quart / demi / finale existe déja
                  $tourExiteDeja = true;
                }
              }
            }
            if($tourExiteDeja == false){
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
            } else {
              echo "<script>alert('Il ne peut y avoir uniquement un seul tour avec ce type par tournoi')</script>";
            }
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
          $tourExiteDeja = false;
          if($tennisTour->getType() != "Intermediaire"){
            foreach($tennisTour->getTennisTournoi()->getTennisTours() as $tour){
              if($tennisTour->getId() != $tour->getId()){
                if($tennisTour->getType() == $tour->getType()){ // le tour quart / demi / finale existe déja
                  $tourExiteDeja = true;
                }
              }
            }
          }
          if($tourExiteDeja == false){
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('tennis_tour_index', [
                'id' => $tennisTour->getTennisTournoi()->getId()
            ]);
          } else {
            echo "<script>alert('Il ne peut y avoir uniquement un seul tour avec ce type par tournoi')</script>";
          }
        }

        return $this->render('tennis_tour/edit.html.twig', [
            'tennis_tour' => $tennisTour,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/repousser-date-fin-tour", name="tennis_tour_repousser_date_fin", methods={"GET","POST"})
     */
    public function repousserDate(Request $request, TennisTour $tennisTour): Response
    {
        $ancienneDate = $tennisTour->getDateFinTour();
        $form = $this->createForm(TennisTourDateFinType::class, $tennisTour);
        $form->handleRequest($request);

        if ($form->isSubmitted()) { //&& $form->isValid()
            if($ancienneDate<$tennisTour->getDateFinTour()){
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('tennis_tour_index', ['id' => $tennisTour->getTennisTournoi()->getId()]);
            }
        }

        return $this->render('tennis_tour/repousserDate.html.twig', [
            'tennis_tour' => $tennisTour,
            'ancienne_date' => $ancienneDate,
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

        return $this->redirectToRoute('tennis_tour_index', ['id'=>$tennisTour->getTennisTournoi()->getId()]);
    }

    /**
     * @Route("/supprimer/{id}", name="tennis_tour_supprimer")
     */
    public function supprimer(TennisTour $tennisTour){
        return $this->render('tennis_tour/supprimer.html.twig', [
            'tennis_tour' => $tennisTour,
        ]);
    }
}
