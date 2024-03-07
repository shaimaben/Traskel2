<?php

namespace App\Controller;

use App\Entity\LivraisonsCadeaux;
use App\Form\LivraisonsCadeauxType;
use App\Repository\LivraisonsCadeauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaisieCadeauController extends AbstractController
{
    #[Route('/listeCadeaux', name: 'listeCadeaux')]
    public function index(LivraisonsCadeauxRepository $LivraisonsCadeauxRepository): Response
    {
        $livraisonsC = $LivraisonsCadeauxRepository->findAll();

        return $this->render('saisie_cadeau/liste.html.twig', [
            'livraisonsC' => $livraisonsC,
        ]);
    }

    #[Route('/listeCadeaux/{id}', name: 'affichCadeaux')]
    public function affichLivraison(LivraisonsCadeaux $livraisonC): Response
    {
        return $this->render('saisie_cadeau/affich.html.twig', [
            'livC' => $livraisonC,
        ]);
    }

    #[Route('/ajouterCadeaux', name: 'ajouterCadeaux')]
    public function ajouterCadeaux(ManagerRegistry $mr, Request $request): Response
    {
        $em = $mr->getManager();
        $livraisonC = new LivraisonsCadeaux();
        $form = $this->createForm(LivraisonsCadeauxType::class, $livraisonC);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($livraisonC);
            $em->flush();

            return $this->redirectToRoute('listeCadeaux');
        }

        return $this->render('saisie_cadeau/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/listeCadeaux/{id}/modifier', name: 'modifierCadeaux')]
    public function modifierCadeaux(Request $request, LivraisonsCadeaux $livraisonC, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivraisonsCadeauxType::class, $livraisonC);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('listeCadeaux');
        }

        return $this->render('saisie_cadeau/modifier.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/listeCadeaux/{id}/delete', name: 'deleteCadeaux')]
    public function deleteCadeaux($id, LivraisonsCadeauxRepository $livCR, ManagerRegistry $mr): Response
    {
        $em = $mr->getManager();
        $livC = $livCR->find($id);
        $em->remove($livC);
        $em->flush();
        
        return $this->redirectToRoute('listeCadeaux');
    }

}
