<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\LivraisonsCadeauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ChercherLivreurController extends AbstractController
{
    #[Route('/chercher-livreur', name: 'chercher_livreur')]
    public function chercherLivreur(Request $request, EntityManagerInterface $entityManager, LivraisonsCadeauxRepository $livraisonsCadeauxR): Response
    {
        $prenom = $request->query->get('prenom');

        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['prenom_user' => $prenom]);

        $livraisons = [];
        $livraisonsCadeaux = [];

        if ($user instanceof User) {
            $livraisons = $user->getLivraisons();
            $livraisonsCadeaux = $livraisonsCadeauxR->findByLivreur($user);
        }

        return $this->render('chercher_livreur/chercherL.html.twig', [
            'user' => $user,
            'livraisons' => $livraisons,
            'livCad' => $livraisonsCadeaux,
        ]);
    }
}
