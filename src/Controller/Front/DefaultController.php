<?php


namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/front")
 *
 * Class DefaultController
 * @package App\Controller\Front
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
        return $this->render('front/index.html.twig');
    }
}