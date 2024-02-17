<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GlobalController extends AbstractController
{

    #[Route('/global', name: 'app_global')]

    public function index(): Response
    {
		$this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");

		/** @var User $user */
		$user = $this->getUser();

		return match ($user->isVerified()) {
			false=> $this->render("global/index.html.twig"),
			//false => $this->render("global/please-verify-email.html.twig"),
		};


        
   /* 
    public function index(): Response
    {
        return $this->render('global/index.html.twig', [
            'controller_name' => 'GlobalController',
        ]);*/
        

        
    }

    #[Route('/Admin', name: 'app_Admin')]
        function indextest(): Response
        {
            return $this->render('Admin/indextest.html.twig');
        }
}
