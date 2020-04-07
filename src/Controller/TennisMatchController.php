<?php

namespace App\Controller;

use App\Entity\TennisMatch;
use App\Entity\TennisSet;
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
      $utilisateurs2 = array();
      $participants = array(); // joueurs qui sont déja dans un match
      foreach($tennisTour->getTennisMatchs() as $match){
        foreach($match->getTennisUtilisateurs() as $user){
          array_push($participants, $user);
        }
      }
      $joueursNonParticipant = array_diff($utilisateurs, $participants);
      foreach($joueursNonParticipant as $user){
        array_push($names, $user->getNomComplet());
        array_push($utilisateurs2, $user);
      }

      $choix = array_combine($names, $utilisateurs2);

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

          $tennisMatch->setTennisTour($tennisTour);
          $tennisTour->addTennisMatch($tennisMatch);

          $tennisMatch->setEtat('Pas encore joué');

          $joueur1 = $form->getData()["joueur_1"];
          $joueur2 = $form->getData()["joueur_2"];

          if($joueur1 != $joueur2){
            $tennisMatch->addTennisUtilisateur($joueur1);
            $tennisMatch->addTennisUtilisateur($joueur2);

            $entityManager->persist($tennisMatch);
            $entityManager->flush();

            return $this->redirectToRoute('tennis_match_index', ['id' => $tennisMatch->getTennisTour()->getId()]);
          } else {
            echo "<script>alert('Vous devez selectionner deux joueurs differents')</script>";
          }
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
     * @Route("/edit/{id}", name="tennis_match_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisMatch $tennisMatch): Response
    {
        $tennisTour = $tennisMatch->getTennisTour();
        $tennisTournoi = $tennisTour->getTennisTournoi();
        $utilisateurs = $tennisTournoi->getTennisUtilisateursParticipant()->toArray();

        $utilisateurs2 = array();
        $participants = array();
        $names = array();

        foreach($tennisTour->getTennisMatchs() as $match){
          if($match->getId() != $tennisMatch->getId()){
            foreach($match->getTennisUtilisateurs() as $user){
              array_push($participants, $user);
            }
          }
        }
        $joueurActuel1 = $tennisMatch->getTennisUtilisateurs()[0];
        $joueurActuel2 = $tennisMatch->getTennisUtilisateurs()[1];

        $utilisateursJoueurs1 = array_diff($utilisateurs, $participants);
        array_unshift($utilisateursJoueurs1, $joueurActuel1);


        $utilisateursJoueurs2 = array_diff($utilisateurs, $participants);
        array_unshift($utilisateursJoueurs2, $joueurActuel2);

        $namesJ1 = array();
        foreach ($utilisateursJoueurs1 as $user){
          array_push($namesJ1, $user->getNomComplet());
        }

        $namesJ2 = array();
        foreach ($utilisateursJoueurs2 as $user){
          array_push($namesJ2, $user->getNomComplet());
        }

        $choixJ1 = array_combine($namesJ1, $utilisateursJoueurs1);
        $choixJ2 = array_combine($namesJ2, $utilisateursJoueurs2);

        $form = $this->createFormBuilder()
              ->add('joueur_1', ChoiceType::class, [
                'choices' => $choixJ1])
              ->add('joueur_2', ChoiceType::class, [
                  'choices' => $choixJ2])
              ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $j1 = $form->getData()["joueur_1"];
            $j2 = $form->getData()["joueur_2"];

            if($j1 != $j2){
              if($j1 != $tennisMatch->getTennisUtilisateurs()[0]){
                $tennisMatch->removeTennisUtilisateur($joueurActuel1);
              }
              if($j2 != $tennisMatch->getTennisUtilisateurs()[1]){
                $tennisMatch->removeTennisUtilisateur($joueurActuel2);
              }

              $tennisMatch->addTennisUtilisateur($j1);
              $tennisMatch->addTennisUtilisateur($j2);

              $this->getDoctrine()->getManager()->flush();

              return $this->redirectToRoute('tennis_match_index', ['id' => $tennisMatch->getTennisTour()->getId()]);
            } else {
              echo "<script>alert('Vous devez selectionner deux joueurs differents')</script>";
            }

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
     * @Route("/{id}/notifier-joueurs", name="tennis_match_notifier_joueurs")
     */
    public function notifierJoueurs(Request $request, TennisMatch $tennisMatch) {
        $tennisMatch->notifierJoueurs();
        return $this->redirectToRoute('tennis_match_index', ['id' => $tennisMatch->getTennisTour()->getId()]);
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

      /**
       * @Route("/eliminer-perdant/{id}", name="tennis_match_eliminer_perdant")
       */
       public function eliminerPerdant(TennisMatch $tennisMatch){
         $nbSetsJ1 = 0;
         $nbSetsJ2 = 0;
         foreach($tennisMatch->getTennisSets() as $set){
           if($set->getNbJeuxDuGagnant() > $set->getNbJeuxDuPerdant()){
             $nbSetsJ1++;
           } else if($set->getNbJeuxDuGagnant() < $set->getNbJeuxDuPerdant()){
             $nbSetsJ2++;
           }
         }
         if($nbSetsJ1 > $nbSetsJ2){
           $perdant = $tennisMatch->getTennisUtilisateurs()[1];
         } else if($nbSetsJ1 < $nbSetsJ2){
           $perdant = $tennisMatch->getTennisUtilisateurs()[0];
         }
         $tennisMatch->getTennisTour()->getTennisTournoi()->removeTennisUtilisateursParticipant($perdant);
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($tennisMatch);
         $entityManager->flush();
         return $this->redirectToRoute('tennis_match_index', ['id' => $tennisMatch->getTennisTour()->getId()]);
       }

}
