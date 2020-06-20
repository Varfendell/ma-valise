<?php

namespace App\Controller\Administration\Crud;

use App\Entity\Hebergement;
use App\Form\Crud\HebergementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hebergement")
 */
class HebergementController extends AbstractController
{
    /**
     * @Route("/", name="hebergement_index", methods={"GET"})
     */
    public function index(): Response
    {
        $hebergements = $this->getDoctrine()
            ->getRepository(Hebergement::class)
            ->findAll();

        return $this->render('hebergement/index.html.twig', [
            'hebergements' => $hebergements,
        ]);
    }

    /**
     * @Route("/new", name="hebergement_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $hebergement = new Hebergement();
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hebergement);
            $entityManager->flush();

            return $this->redirectToRoute('hebergement_index');
        }

        return $this->render('hebergement/new.html.twig', [
            'hebergement' => $hebergement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hebergement_show", methods={"GET"})
     * @param Hebergement $hebergement
     * @return Response
     */
    public function show(Hebergement $hebergement): Response
    {
        return $this->render('hebergement/show.html.twig', [
            'hebergement' => $hebergement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hebergement_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Hebergement $hebergement
     * @return Response
     */
    public function edit(Request $request, Hebergement $hebergement): Response
    {
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hebergement_index');
        }

        return $this->render('hebergement/edit.html.twig', [
            'hebergement' => $hebergement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hebergement_delete", methods={"DELETE"})
     * @param Request $request
     * @param Hebergement $hebergement
     * @return Response
     */
    public function delete(Request $request, Hebergement $hebergement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hebergement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hebergement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hebergement_index');
    }
}
