<?php

namespace App\Controller;

use App\Entity\TennisTournoi;
use App\Form\TennisTournoiType;
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
     * @Route("/new", name="tennis_tournoi_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tennisTournoi = new TennisTournoi();
        $form = $this->createForm(TennisTournoiType::class, $tennisTournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_tournoi_index');
        }

        return $this->render('tennis_tournoi/edit.html.twig', [
            'tennis_tournoi' => $tennisTournoi,
            'form' => $form->createView(),
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
}
