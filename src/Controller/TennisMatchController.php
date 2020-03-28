<?php

namespace App\Controller;

use App\Entity\TennisMatch;
use App\Entity\TennisTour;
use App\Form\TennisMatchType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\TennisMatchRepository;
use App\Repository\TennisSetRepository;
use App\Repository\TennisTourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("matchs")
 */
class TennisMatchController extends AbstractController
{
    /**
     * @Route("/matchs-tour/{id}", name="tennis_match_index", methods={"GET"})
     */
    public function index(TennisMatchRepository $tennisMatchRepository, TennisSetRepository $tennisSetRepository, TennisTourRepository $tennisTourRepository, $id): Response
    {
        return $this->render('tennis_match/index.html.twig', [
            'tennis_matches' => $tennisMatchRepository->findByTennisTour($id),
            'tennis_sets' => $tennisSetRepository->findAll(),
			      'tennis_tour' => $tennisTourRepository->find($id)
        ]);
    }

    /**
     * @Route("/new/{id}", name="tennis_match_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id): Response {

      $tennisTour = $this->getDoctrine()->getManager()->getRepository(TennisTour::class)->find($id);
      $tennisTournoi = $tennisTour->getTennisTournoi();
      $utilisateurs = $tennisTournoi->getTennisUtilisateursParticipant()->toArray();

      $names = array();
      foreach ($utilisateurs as $user){
        array_push($names, $user->getNomComplet());
      }

      $choix = array_combine($names, $utilisateurs);

      $tennisMatch = new TennisMatch();

      $form = $this->createFormBuilder()
            ->add('joueur_1', ChoiceType::class, [
              'choices' => $choix])
            ->add('joueur_2', ChoiceType::class, [
                'choices' => $choix])
            ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted()) {
          $entityManager = $this->getDoctrine()->getManager();

          // RELATION BI-DIRECTIONELLE AVEC TENNIS_TOUR
          $tennisMatch->setTennisTour($tennisTour);
          $tennisTour->addTennisMatch($tennisMatch);

          $tennisMatch->setEtat('Pas encore joué');

          $joueur1 = $form->getData()["joueur_1"];
          $joueur2 = $form->getData()["joueur_2"];

          $tennisMatch->addTennisUtilisateur($joueur1);
          $tennisMatch->addTennisUtilisateur($joueur2);

          $entityManager->persist($tennisMatch);
          $entityManager->flush();

          return $this->redirectToRoute('tennis_match_index', ['id' => $tennisMatch->getTennisTour()->getId()]);
      }

      return $this->render('tennis_match/new.html.twig', [
          'tennis_match' => $tennisMatch,
          'form' => $form->createView(),
      ]);
    }

    /**
     * @Route("/{id}", name="tennis_match_show", methods={"GET"})
     */
    public function show(TennisMatch $tennisMatch): Response
    {
        return $this->render('tennis_match/show.html.twig', [
            'tennis_match' => $tennisMatch,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_match_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisMatch $tennisMatch): Response
    {
        $form = $this->createForm(TennisMatchType::class, $tennisMatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_match_index', ['id' => $tennisMatch->getTennisTour()->getId()]);
        }

        return $this->render('tennis_match/edit.html.twig', [
            'tennis_match' => $tennisMatch,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier-scores", name="tennis_match_edit_scores", methods={"GET","POST"})
     */
    public function editScores(Request $request, TennisMatch $tennisMatch): Response
    {
        $form = $this->createForm(TennisMatchType::class, $tennisMatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('tennis_match_index', ['id' => $tennisMatch->getTennisTour()->getId()]);
        }

        return $this->render('tennis_match/edit.html.twig', [
            'tennis_match' => $tennisMatch,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_match_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TennisMatch $tennisMatch): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisMatch->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisMatch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_match_index', ['id' => $tennisMatch->getTennisTour()->getId()]);
    }
    /**
     * @Route("/supprimer/{id}", name="tennis_match_supprimer")
     */
    public function supprimer(TennisMatch $tennisMatch){
        return $this->render('tennis_match/supprimer.html.twig', [
            'tennis_match' => $tennisMatch,
        ]);
    }
}
