<?php

namespace App\Controller\Administration\Crud;

use App\Controller\Administration\DefaultController;
use App\Entity\Project;
use App\Form\Crud\ProjectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project")
 */
class ProjectController extends DefaultController
{
	/**
	 * @Route("/", name="project_index", methods={"GET"})
	 */
	public function index(): Response
	{
		$projects = $this->getDoctrine()->getRepository(Project::class)->findAll();

		return $this->render('administration/crud/project/index.html.twig', ['projects' => $projects,]);
	}

	/**
	 * @Route("/new", name="project_new", methods={"GET","POST"})
	 * @param Request $request
	 * @return Response
	 */
	public function new(Request $request): Response
	{
		$project = new Project();
		$form = $this->createForm(ProjectType::class, $project);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($project);
			$entityManager->flush();

			return $this->redirectToRoute('project_index');
		}

		return $this->render('administration/crud/project/new.html.twig', ['project' => $project, 'form' => $form->createView(),]);
	}

	/**
	 * @Route("/{id}", name="project_show", methods={"GET"})
	 * @param Project $project
	 * @return Response
	 */
	public function show(Project $project): Response
	{
		return $this->render('administration/crud/project/show.html.twig', ['project' => $project,]);
	}

	/**
	 * @Route("/{id}/edit", name="project_edit", methods={"GET","POST"})
	 * @param Request $request
	 * @param Project $project
	 * @return Response
	 */
	public function edit(Request $request, Project $project): Response
	{
		$form = $this->createForm(ProjectType::class, $project);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('project_index');
		}

		return $this->render('administration/crud/project/edit.html.twig', ['project' => $project, 'form' => $form->createView(),]);
	}

	/**
	 * @Route("/{id}", name="project_delete", methods={"DELETE"})
	 * @param Request $request
	 * @param Project $project
	 * @return Response
	 */
	public function delete(Request $request, Project $project): Response
	{
		if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($project);
			$entityManager->flush();
		}

		return $this->redirectToRoute('project_index');
	}
}
