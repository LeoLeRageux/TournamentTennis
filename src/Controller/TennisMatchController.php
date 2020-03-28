<?php

namespace App\Controller;

use App\Entity\TennisMatch;
use App\Entity\TennisSet;
use App\Form\TennisMatchType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\TennisMatchRepository;
use App\Repository\TennisSetRepository;
use App\Repository\TennisTourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
     * @Route("/{id}/modifier-match", name="tennis_match_edit_scores", methods={"GET","POST"})
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

    /**
     * @Route("/saisir-resultat/{id}", name="tennis_match_saisir_resultat")
     */
     public function saisirResultatMatch(Request $request, TennisMatch $tennisMatch){
       $form = $this->createFormBuilder()
          ->add('jeuG1', IntegerType::class)
          ->add('jeuD1', IntegerType::class)
          ->add('jeuG2', IntegerType::class)
          ->add('jeuD2', IntegerType::class)
          ->add('jeuG3', IntegerType::class, ['required' => false])
          ->add('jeuD3', IntegerType::class, ['required' => false])
          ->add('jeuG4', IntegerType::class, ['required' => false])
          ->add('jeuD4', IntegerType::class, ['required' => false])
          ->add('jeuG5', IntegerType::class, ['required' => false])
          ->add('jeuD5', IntegerType::class, ['required' => false])
          ->getForm();
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
         foreach ($tennisMatch->getTennisSets() as $set) {
           $tennisMatch->removeTennisSet($set);
         }

         for($i=1; $i<=$tennisMatch->getTennisTour()->getTennisTournoi()->getNbSetsGagnants(); $i++){
           $set = new TennisSet();
           $set->setNbJeuxDuGagnant($form->getData()["jeuG".$i]);
           $set->setNbJeuxDuPerdant($form->getData()["jeuD".$i]);
           $tennisMatch->addTennisSet($set);
           $tennisMatch->setEtat("Terminé");
         }

         $this->getDoctrine()->getManager()->flush();
         return $this->redirectToRoute('tennis_match_index', ['id' => $tennisMatch->getTennisTour()->getId()]);
       }

       return $this->render('tennis_match/saisirResultats.html.twig', [
           'tennis_match' => $tennisMatch,
           'form' => $form->createView(),
       ]);
     }

     /**
      * @Route("/modifier-resultat/{id}", name="tennis_match_modifier_resultat")
      */
      public function modifierResultatMatch(Request $request, TennisMatch $tennisMatch){
        $form = $this->createFormBuilder()
            ->add('jeuG1', IntegerType::class)
            ->add('jeuD1', IntegerType::class)
            ->add('jeuG2', IntegerType::class)
            ->add('jeuD2', IntegerType::class)
            ->add('jeuG3', IntegerType::class, ['required' => false])
            ->add('jeuD3', IntegerType::class, ['required' => false])
            ->add('jeuG4', IntegerType::class, ['required' => false])
            ->add('jeuD4', IntegerType::class, ['required' => false])
            ->add('jeuG5', IntegerType::class, ['required' => false])
            ->add('jeuD5', IntegerType::class, ['required' => false])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $i = 1;
          foreach ($tennisMatch->getTennisSets() as $set) {
            $set->setNbJeuxDuGagnant($form->getData()["jeuG".$i]);
            $set->setNbJeuxDuPerdant($form->getData()["jeuD".$i]);
            $tennisMatch->addTennisSet($set);
            $i++;
          }

          $this->getDoctrine()->getManager()->flush();
          return $this->redirectToRoute('tennis_match_index', ['id' => $tennisMatch->getTennisTour()->getId()]);
        }

        return $this->render('tennis_match/modifierResultats.html.twig', [
            'tennis_match' => $tennisMatch,
            'form' => $form->createView(),
            'utilisateurs' => $tennisMatch
        ]);
      }
}
