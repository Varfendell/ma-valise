<?php


namespace App\Controller\Administration;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration")
 *
 * Class WelcomeController
 * @package App\Controller\Common
 */
class DefaultController extends AbstractController
{

    /**
     * @Route("/")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('Administration/index.html.twig');
    }
}