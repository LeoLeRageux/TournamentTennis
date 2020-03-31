<?php

namespace App\Controller;

use App\Entity\TennisTournoi;
use App\Form\TennisTournoiType;
use App\Form\TennisTournoiDateFin;
use App\Form\TennisTournoiDateDebut;
use App\Form\TennisTournoiUtilisateursType;
use App\Repository\TennisTournoiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

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
            'tennis_tournois' => $tennisTournoiRepository->findByTennisUtilisateur($this->getUser()),
        ]);
    }

    /**
     * @Route("/inscrits", name="tennis_tournoi_index_inscrits", methods={"GET"})
     */
    public function indexInscrits(TennisTournoiRepository $tennisTournoiRepository): Response
    {
        return $this->render('tennis_tournoi/indexInscrit.html.twig', [
            'tennis_tournois' => $tennisTournoiRepository->findAll(),
        ]);
    }

    /**
     * @Route("/rechercher", name="tennis_tournoi_rechercher", methods={"GET"})
     */
    public function rechercher(TennisTournoiRepository $tennisTournoiRepository): Response
    {
        return $this->render('tennis_tournoi/rechercher.html.twig', [
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
            $tennisTournoi->setStatut("Non Commencé");
            $tennisTournoi->setTennisUtilisateur($this->getUser());

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
     * @Route("/changer-statut/{id}", name="tennis_tournoi_changer_statut")
     */
    public function changerStatut(TennisTournoi $tennisTournoi): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        if($tennisTournoi->getStatut() == "Non Commencé"){
          $tennisTournoi->setStatut("Phase d'incriptions");
        } else if($tennisTournoi->getStatut() == "Phase d'incriptions"){
          $tennisTournoi->setStatut("Commencé");
        } else if($tennisTournoi->getStatut() == "Commencé"){
            $tennisTournoi->setStatut("Terminé");
        }
        $entityManager->flush();
        return $this->redirectToRoute('tennis_tour_index', ['id' => $tennisTournoi->getId()]);
    }

	  /**
     * @Route("/rechercher-tournoi/{id}", name="tennis_tournoi_afficher_tournoi_recherche")
     */
    public function afficherTournoiRecherche(Request $request, TennisTournoi $tennisTournoi): Response {

      if($tennisTournoi->getMotDePasse() == null){
        
      }

      $form = $this->createFormBuilder()
        ->add('mdp', PasswordType::class)
        ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted()) { //&& $form->isValid()
         if($form->getData()["mdp"] == $tennisTournoi->getMotDePasse()){
           if($tennisTournoi->getValidationInscriptions()){
             echo "<script>alert('Votre demande dinscription à été prise en compte')</script>";
             $tennisTournoi->addTennisUtilisateursDemandeInscription($this->getUser());
           } else {
             $tennisTournoi->addTennisUtilisateursParticipant($this->getUser());
           }
           $this->getDoctrine()->getManager()->flush();
           return $this->redirectToRoute('tennis_tournoi_index');
         }
         else {
           echo "<script>alert('Mot de passe incorrect')</script>";
         }
      }

      return $this->render('tennis_tournoi/afficherTournoiRecherche.html.twig', [
          'tennis_tournoi' => $tennisTournoi,
          'form' => $form->createView()
      ]);
    }

    /**
     * @Route("/liste-inscrits/{id}", name="tennis_tournoi_afficher_liste_inscrits")
     */
     public function afficherListeInscrits(TennisTournoi $tennisTournoi): Response
     {
         return $this->render('tennis_tournoi/afficherListeInscrits.html.twig', [
             'tennis_tournoi' => $tennisTournoi,
         ]);
     }

    /**
     * @Route("/inscrire-utilisateur/{id}", name="tennis_tournoi_inscrire_utilisateur")
     */
     public function inscrireUtilisateur(Request $request, TennisTournoi $tennisTournoi): Response
     {
       $form = $this->createForm(TennisTournoiUtilisateursType::class, $tennisTournoi);
       $form->handleRequest($request);

       if ($form->isSubmitted()) { //&& $form->isValid()
            $nbJoueurs = count($form->getData()->getTennisUtilisateursParticipant()->toArray());
            if($nbJoueurs <= $tennisTournoi->getNbPlaces() - count($tennisTournoi->getTennisUtilisateursParticipant()->toArray())){
              $this->getDoctrine()->getManager()->flush();
              return $this->redirectToRoute('tennis_tournoi_inscrire_utilisateur', ['id' => $tennisTournoi->getId()]);
          }
       }

       return $this->render('tennis_tournoi/inscrireUtilisateur.html.twig', [
           'tennis_tournoi' => $tennisTournoi,
           'form' => $form->createView()
       ]);
     }

     /**
      * @Route("/desinscription/{id}/{utilisateur}", name="tennis_tournoi_desinscrire")
      */
     public function desinscrireJoueur(TennisTournoiRepository $tennisTournoiRepository, $id, $utilisateur): Response
     {
        $tennisTournoi = $tennisTournoiRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        foreach($tennisTournoi->getTennisUtilisateursParticipant() as $user){
          if($user->getId() == $utilisateur){
            $tennisTournoi->removeTennisUtilisateursParticipant($user);
            $tennisTournoi->removeTennisUtilisateursDemandeInscription($user);
          }
        }
        $entityManager->flush();
        return $this->redirectToRoute('tennis_tournoi_index');
     }
}
