<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\UserRepository;

class StatController extends AbstractController
{
    #[Route('/', name: 'app_stat')]
    public function index(): Response
    {
        return $this->render('stat/index.html.twig', [
            'controller_name' => 'StatController',
        ]);
    }

    #[Route('/stat', name: 'app_showStat')]

    public function stat (UserRepository $userRepository)
{
    $adminCount = $userRepository->countUsersByRole('ROLE_ADMIN');
    $livererCount = $userRepository->countUsersByRole('ROLE_LIVREUR');
    $userCount = $userRepository->countUsersByRole('ROLE_USER');


    return $this->render('user/stat.html.twig', [
        'adminCount' => $adminCount,
        'livererCount' => $livererCount,
        'userCount' => $userCount,
    ]);
}
}
