<?php

namespace App\Controller;

use App\Entity\TennisSet;
use App\Form\TennisSetType;
use App\Repository\TennisSetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sets")
 */
class TennisSetController extends AbstractController
{
    /**
     * @Route("/", name="tennis_set_index", methods={"GET"})
     */
    public function index(TennisSetRepository $tennisSetRepository): Response
    {
        return $this->render('tennis_set/index.html.twig', [
            'tennis_sets' => $tennisSetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tennis_set_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tennisSet = new TennisSet();
        $form = $this->createForm(TennisSetType::class, $tennisSet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tennisSet);
            $entityManager->flush();

            return $this->redirectToRoute('tennis_set_index');
        }

        return $this->render('tennis_set/new.html.twig', [
            'tennis_set' => $tennisSet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_set_show", methods={"GET"})
     */
    public function show(TennisSet $tennisSet): Response
    {
        return $this->render('tennis_set/show.html.twig', [
            'tennis_set' => $tennisSet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tennis_set_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TennisSet $tennisSet): Response
    {
        $form = $this->createForm(TennisSetType::class, $tennisSet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennis_set_index');
        }

        return $this->render('tennis_set/edit.html.twig', [
            'tennis_set' => $tennisSet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tennis_set_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TennisSet $tennisSet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tennisSet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tennisSet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tennis_set_index');
    }
}
