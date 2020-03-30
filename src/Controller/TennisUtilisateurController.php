<?php

namespace App\Controller;

use App\Entity\TennisUtilisateur;
use App\Form\TennisUtilisateurType;
use App\Repository\TennisUtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tennis/utilisateur")
 */
class TennisUtilisateurController extends AbstractController
{
    /**
     * @Route("/", name="tennis_utilisateur_index", methods={"GET"})
     */
    public function index(TennisUtilisateurRepository $tennisUtilisateurRepository): Response
    {
        return $this->render('tennis_utilisateur/index.html.twig', [
            'tennis_utilisateurs' => $tennisUtilisateurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tennis_utilisateur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tennisUtilisateur = new TennisUtilisateur();
        $form = $this->createForm(TennisUtilisateurType::class, $tennisUtilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tennisUtilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('tennis_utilisateur_index');
        }

        return $this->render('tennis_utilisateur/new.html.twig', [
            'tennis_utilisateur' => $tennisUtilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profil/{id}", name="tennis_utilisateur_show", methods={"GET"})
     */
    public function show(TennisUtilisateur $tennisUtilisateur): Response
    {
        return $this->render('tennis_utilisateur/show.html.twig', [
            'tennis_utilisateur' => $tennisUtilisateur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_utilisateur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisUtilisateur $tennisUtilisateur): Response
    {
        $form = $this->createForm(TennisUtilisateurType::class, $tennisUtilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_utilisateur_show',['id'=>$this->getUser()->getId()]);
        }

        return $this->render('tennis_utilisateur/edit.html.twig', [
            'tennis_utilisateur' => $tennisUtilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_utilisateur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TennisUtilisateur $tennisUtilisateur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisUtilisateur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisUtilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_utilisateur_index');
    }
}
