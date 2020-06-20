<?php


namespace App\Controller\Agence;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/agence", name="agence_")
 *
 * Class DefaultController
 * @package App\Controller\Front
 */
class DefaultController extends AbstractController
{

	/**
	 * @Route("/", name="index")
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->render('agence/index.html.twig');
	}
}