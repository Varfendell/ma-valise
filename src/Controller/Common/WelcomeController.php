<?php


namespace App\Controller\Common;

use App\Entity\User;
use App\Form\Common\AuthenticationType;
use App\Form\Common\CreateAccountType;
use App\Manager\UserManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class WelcomeController
 * @package App\Controller\Common
 */
class WelcomeController extends AbstractController
{

	/**
	 * @Route("/login", name="login")
	 *
	 * @param AuthenticationUtils $authenticationUtils
	 * @return Response
	 */
	public function login(AuthenticationUtils $authenticationUtils): Response
	{
		if ($this->getUser()) {
			return $this->redirectToRoute('app_common_welcome_accueil');
		}

		$form = $this->createForm(AuthenticationType::class);
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('login/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'form' => $form->createView(),]);
	}

	/**
	 * @Route("/logout")
	 */
	public function logout()
	{
		return $this->redirectToRoute('login');
	}

	/**
	 * @Route("/create-account")
	 *
	 * @param Request $request
	 * @param UserManager $userManager
	 * @return RedirectResponse|Response
	 * @throws Exception
	 */
	public function createAccountAction(Request $request, UserManager $userManager)
	{
		$form = $this->createForm(CreateAccountType::class);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$user = $form->getData();
			$userManager->createUser($user);
			$this->addFlash('success', 'Compte créé.');
			return $this->redirectToRoute('login');
		}
		return $this->render('login/create-account.html.twig', ['form' => $form->createView(),]);
	}

	/**
	 * @Route("/")
	 *
	 * @return RedirectResponse
	 */
	public function accueil()
	{
		if (empty($this->getUser())) {
			return $this->redirectToRoute('login');
		}
		$roles = $this->getUser()->getRoles();
		if (in_array(User::ROLE_ADMIN, $roles)) {
			return $this->redirectToRoute('app_administration_default_index');
		} else if(in_array(User::ROLE_USER, $roles)){
			return $this->redirectToRoute('app_front_default_index');
		} else {
			return $this->redirectToRoute('login');
		}
	}
}