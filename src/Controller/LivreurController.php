<?php

namespace App\Controller;

use App\Repository\LivraisonRepository;
use App\Repository\LivraisonsCadeauxRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LivreurController extends AbstractController
{
    #[Route('/livreur', name: 'accueil')]
    public function index(LivraisonRepository $liv): Response
    {

        $livraisons = $liv->findBy([], ['createdAt' => 'ASC'], 4);

        $totalLivraisons = $liv->count([]);

        return $this->render('livreur/accueil.html.twig', [
            'livraisons' => $livraisons,
            'totalLivraisons' => $totalLivraisons,
        ]);
    }

    #[Route('/livreur/produits', name: 'livraisons_produits')]
    public function produitsLivreur(LivraisonRepository $liv): Response
    {
        $livraisons = $liv->findBy(['isConfirmed' => false], ['createdAt' => 'ASC']);

        return $this->render('livreur/livraisons.html.twig', [
            'livraisons' => $livraisons,
        ]);
    }

    #[Route('/livraisons/{id}/confirmProduit', name: 'confirmerLivraison', methods: ['POST'])]
    public function confirmerLivraison($id,LivraisonRepository $liv,ManagerRegistry $doctrine): Response
    {
        $livraison = $liv->find($id);

        $livraison->setIsConfirmed(true);

        $entityManager = $doctrine->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('livraisons_produits');
    }

    #[Route('/livreur/cadeaux', name: 'livraisons_cadeaux')]
    public function cadeauxLivreur(LivraisonsCadeauxRepository $livCad): Response
    {
        $livCadeaux = $livCad->findBy(['isConfirmed' => false], ['createdAt' => 'ASC']);

        return $this->render('livreur/listeLivCad.html.twig', [
            'livCad'=>$livCadeaux,
        ]);
    }

    #[Route('/livraisons/{id}/confirmCadeau', name: 'confirmerLivraisonCadeaux', methods: ['POST'])]
    public function confirmerLivraisonCadeaux($id,LivraisonsCadeauxRepository $livC,ManagerRegistry $doctrine): Response
    {
        $livraisonC = $livC->find($id);

        $livraisonC->setIsConfirmed(true);

        $entityManager = $doctrine->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('livraisons_cadeaux');
    }
}
