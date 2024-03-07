<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Repository\LivraisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaisieLivraisonController extends AbstractController
{
    #[Route('/listeLivraisons', name: 'listeLivraisons')]
    public function index(LivraisonRepository $livraisonRepository): Response
    {
        $livraisons = $livraisonRepository->findAll();

        return $this->render('saisie_livraison/liste.html.twig', [
            'livraisons' => $livraisons,
        ]);
    }

    #[Route('/listeLivraisons/{id}', name: 'affichLivraison')]
    public function affichLivraison(Livraison $livraison): Response
    {
        return $this->render('saisie_livraison/affich.html.twig', [
            'livraison' => $livraison,
        ]);
    }

    #[Route('/ajouterLivraisons', name: 'ajouterLivraison')]
    public function ajouterLivraison(ManagerRegistry $mr, Request $request): Response
    {
        $em = $mr->getManager();
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($livraison);
            $em->flush();

            return $this->redirectToRoute('listeLivraisons');
        }

        return $this->render('saisie_livraison/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/listeLivraisons/{id}/modifier', name: 'modifierLivraison')]
    public function modifierLivraison(Request $request, Livraison $livraison, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('listeLivraisons');
        }

        return $this->render('saisie_livraison/modifier.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/listeLivraisons/{id}/delete', name: 'deleteLivraison')]
    public function deleteLivraison($id, LivraisonRepository $livR, ManagerRegistry $mr): Response
    {
        $em = $mr->getManager();
        $dataid = $livR->find($id);
        $em->remove($dataid);
        $em->flush();
        
        return $this->redirectToRoute('listeLivraisons');
    }

}
