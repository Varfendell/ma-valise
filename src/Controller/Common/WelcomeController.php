<?php


namespace App\Controller\Common;

use App\Manager\UserManager;
use App\Form\Common\AuthenticationType;
use App\Form\Common\CreateAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/welcome")
 *
 * Class WelcomeController
 * @package App\Controller\Common
 */
class WelcomeController extends AbstractController
{
    /**
     * @Route("/login")
     *
     * @param Request $request
     * @param UserManager $userManager
     * @return Response
     */
    public function loginAction(Request $request, UserManager $userManager)
    {
        $form = $this->createForm(AuthenticationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];
            $password = $data['password'];
            $isCorrect = $userManager->authenticateUser($email, $password);
            if ($isCorrect) {

                return $this->redirectToRoute('welcome');
            }
            $this->addFlash('warning', 'Email ou mot de passe incorrecte');
        }
        return $this->render('login/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create-account")
     *
     * @param Request $request
     * @param UserManager $userManager
     * @return Response
     */
    public function CreateAccountAction(Request $request, UserManager $userManager)
    {
        $form = $this->createForm(CreateAccountType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userManager->createUser($user);
            return $this->render('login/create-account-success.html.twig');
        }
        return $this->render('login/create-account.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}