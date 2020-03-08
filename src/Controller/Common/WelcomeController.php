<?php


namespace App\Controller\Common;

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
     * @param Request $request
     * @param UserManager $userManager
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function loginAction(
        Request $request,
        UserManager $userManager,
        AuthenticationUtils $authenticationUtils
    )
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('target_path');
         }

        $form = $this->createForm(AuthenticationType::class);

        // get the login error if there is one
        $authenticationUtils->getLastAuthenticationError();

//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//            $email = $data['email'];
//            $password = $data['password'];
//            $isCorrect = $userManager->authenticateUser($email, $password);
//            if ($isCorrect) {
//                return $this->redirectToRoute('app_common_welcome_accueil');
//            }
//            $this->addFlash('warning', 'Email ou mot de passe incorrecte.');
//        }
        return $this->render('login/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('app_common_welcome_login');
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
            return $this->redirectToRoute('app_common_welcome_login');
        }
        return $this->render('login/create-account.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/accueil")
     *
     * @return Response
     */
    public function accueilAction()
    {
        $role = 'user';// 'admin';
        if ($role == 'admin') {
            return $this->redirectToRoute('app_administration_default_index');
        } else {
            return $this->redirectToRoute('app_front_default_index');
        }
    }
}