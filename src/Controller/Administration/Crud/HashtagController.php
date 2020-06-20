<?php

namespace App\Controller\Administration\Crud;

use App\Entity\Hashtag;
use App\Form\HashtagType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hashtag")
 */
class HashtagController extends AbstractController
{
    /**
     * @Route("/", name="hashtag_index", methods={"GET"})
     */
    public function index(): Response
    {
        $hashtags = $this->getDoctrine()
            ->getRepository(Hashtag::class)
            ->findAll();

        return $this->render('administration/crud/hashtag/index.html.twig', [
            'hashtags' => $hashtags,
        ]);
    }

	/**
	 * @Route("/new", name="hashtag_new", methods={"GET","POST"})
	 *
	 * @param Request $request
	 * @return Response
	 */
    public function new(Request $request): Response
    {
        $hashtag = new Hashtag();
        $form = $this->createForm(HashtagType::class, $hashtag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hashtag);
            $entityManager->flush();

            return $this->redirectToRoute('hashtag_index');
        }

        return $this->render('administration/crud/hashtag/new.html.twig', [
            'hashtag' => $hashtag,
            'form' => $form->createView(),
        ]);
    }

	/**
	 * @Route("/{id}", name="hashtag_show", methods={"GET"})
	 *
	 * @param Hashtag $hashtag
	 * @return Response
	 */
    public function show(Hashtag $hashtag): Response
    {
        return $this->render('administration/crud/hashtag/show.html.twig', [
            'hashtag' => $hashtag,
        ]);
    }

	/**
	 * @Route("/{id}/edit", name="hashtag_edit", methods={"GET","POST"})
	 *
	 * @param Request $request
	 * @param Hashtag $hashtag
	 * @return Response
	 */
    public function edit(Request $request, Hashtag $hashtag): Response
    {
        $form = $this->createForm(HashtagType::class, $hashtag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hashtag_index');
        }

        return $this->render('administration/crud/hashtag/edit.html.twig', [
            'hashtag' => $hashtag,
            'form' => $form->createView(),
        ]);
    }

	/**
	 * @Route("/{id}", name="hashtag_delete", methods={"DELETE"})
	 *
	 * @param Request $request
	 * @param Hashtag $hashtag
	 * @return Response
	 */
    public function delete(Request $request, Hashtag $hashtag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hashtag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hashtag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hashtag_index');
    }
}
