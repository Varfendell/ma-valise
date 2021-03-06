<?php

namespace App\Controller\Administration\Crud;

use App\Controller\Administration\DefaultController;
use App\Entity\User;
use App\Form\Crud\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends DefaultController
{
	/**
	 * @Route("/", name="user_index", methods={"GET"})
	 */
	public function index(): Response
	{
		$users = $this->getDoctrine()->getRepository(User::class)->findAll();

		return $this->render('administration/crud/user/index.html.twig', ['users' => $users,]);
	}

	/**
	 * @Route("/new", name="user_new", methods={"GET","POST"})
	 * @param Request $request
	 * @return Response
	 */
	public function new(Request $request): Response
	{
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();

			return $this->redirectToRoute('user_index');
		}

		return $this->render('administration/crud/user/new.html.twig', ['user' => $user, 'form' => $form->createView(),]);
	}

	/**
	 * @Route("/{id}", name="user_show", methods={"GET"})
	 * @param User $user
	 * @return Response
	 */
	public function show(User $user): Response
	{
		return $this->render('administration/crud/user/show.html.twig', ['user' => $user,]);
	}

	/**
	 * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
	 * @param Request $request
	 * @param User $user
	 * @return Response
	 */
	public function edit(Request $request, User $user): Response
	{
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('user_index');
		}

		return $this->render('administration/crud/user/edit.html.twig', ['user' => $user, 'form' => $form->createView(),]);
	}

	/**
	 * @Route("/{id}", name="user_delete", methods={"DELETE"})
	 * @param Request $request
	 * @param User $user
	 * @return Response
	 */
	public function delete(Request $request, User $user): Response
	{
		if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($user);
			$entityManager->flush();
		}

		return $this->redirectToRoute('user_index');
	}

	/**
	 * @Route("/{id}/change-password", name="user_change_password", methods={"DELETE"})
     * @param Request $request
     * @param User $user
	 * @return Response
	 */
	public function changePassword(Request $request, User $user): Response
	{
		return $this->json(['Work in progress']);
	}
}
