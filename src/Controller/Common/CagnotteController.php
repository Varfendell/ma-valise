<?php

namespace App\Controller\Common;

use App\Entity\Cagnotte;
use App\Form\CagnotteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cagnotte")
 */
class CagnotteController extends AbstractController
{
    /**
     * @Route("/", name="cagnotte_index", methods={"GET"})
     */
    public function index(): Response
    {
        $cagnottes = $this->getDoctrine()
            ->getRepository(Cagnotte::class)
            ->findAll();

        return $this->render('cagnotte/index.html.twig', [
            'cagnottes' => $cagnottes,
        ]);
    }

    /**
     * @Route("/new", name="cagnotte_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cagnotte = new Cagnotte();
        $form = $this->createForm(CagnotteType::class, $cagnotte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cagnotte);
            $entityManager->flush();

            return $this->redirectToRoute('cagnotte_index');
        }

        return $this->render('cagnotte/new.html.twig', [
            'cagnotte' => $cagnotte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cagnotte_show", methods={"GET"})
     */
    public function show(Cagnotte $cagnotte): Response
    {
        return $this->render('cagnotte/show.html.twig', [
            'cagnotte' => $cagnotte,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cagnotte_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cagnotte $cagnotte): Response
    {
        $form = $this->createForm(CagnotteType::class, $cagnotte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cagnotte_index');
        }

        return $this->render('cagnotte/edit.html.twig', [
            'cagnotte' => $cagnotte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cagnotte_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cagnotte $cagnotte): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cagnotte->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cagnotte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cagnotte_index');
    }
}
