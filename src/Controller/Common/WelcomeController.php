<?php


namespace App\Controller\Common;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/login")
 *
 * Class WelcomeController
 * @package App\Controller\Common
 */
class WelcomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function loginAction(){
        return $this->render('login/login.html.twig');
    }
}