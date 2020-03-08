<?php

namespace App\Controller\Administration\Crud;

use App\Controller\Administration\DefaultController;
use App\Entity\Participant;
use App\Form\Crud\ParticipantType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participant")
 */
class ParticipantController extends DefaultController
{
	/**
	 * @Route("/", name="participant_index", methods={"GET"})
	 */
	public function index(): Response
	{
		$participants = $this->getDoctrine()->getRepository(Participant::class)->findAll();

		return $this->render('administration/crud/participant/index.html.twig', ['participants' => $participants,]);
	}

	/**
	 * @Route("/new", name="participant_new", methods={"GET","POST"})
	 * @param Request $request
	 * @return Response
	 */
	public function new(Request $request): Response
	{
		$participant = new Participant();
		$form = $this->createForm(ParticipantType::class, $participant);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($participant);
			$entityManager->flush();

			return $this->redirectToRoute('participant_index');
		}

		return $this->render('administration/crud/participant/new.html.twig', ['participant' => $participant, 'form' => $form->createView(),]);
	}

	/**
	 * @Route("/{id}", name="participant_show", methods={"GET"})
	 * @param Participant $participant
	 * @return Response
	 */
	public function show(Participant $participant): Response
	{
		return $this->render('administration/crud/participant/show.html.twig', ['participant' => $participant,]);
	}

	/**
	 * @Route("/{id}/edit", name="participant_edit", methods={"GET","POST"})
	 * @param Request $request
	 * @param Participant $participant
	 * @return Response
	 */
	public function edit(Request $request, Participant $participant): Response
	{
		$form = $this->createForm(ParticipantType::class, $participant);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('participant_index');
		}

		return $this->render('administration/crud/participant/edit.html.twig', ['participant' => $participant, 'form' => $form->createView(),]);
	}

	/**
	 * @Route("/{id}", name="participant_delete", methods={"DELETE"})
	 * @param Request $request
	 * @param Participant $participant
	 * @return Response
	 */
	public function delete(Request $request, Participant $participant): Response
	{
		if ($this->isCsrfTokenValid('delete' . $participant->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($participant);
			$entityManager->flush();
		}

		return $this->redirectToRoute('participant_index');
	}
}
