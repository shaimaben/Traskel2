<?php

namespace App\Controller;

use App\Entity\CategorieProd;
use App\Form\CategorieProdType;
use App\Repository\CategorieProdRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categorie/prod')]
class CategorieProdController extends AbstractController
{
    #[Route('/', name: 'app_categorie_prod_index', methods: ['GET'])]
    public function index(CategorieProdRepository $categorieProdRepository): Response
    {
        return $this->render('categorie_prod/index.html.twig', [
            'categorie_prods' => $categorieProdRepository->findAll(),
        ]);
    }
    





    #[Route('/stats', name: 'stats', methods: ['GET', 'POST'])]
    public function statistiques(CategorieProdRepository $categRepo, ProduitRepository $prodRepo){
        // On va chercher toutes les catégories
        $categories = $categRepo->findAll();
 
        $categNom = [];
        $categColor = [];
        $categCount = [];
 
        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($categories as $categorie){
            $categNom[] = $categorie->getCategorieProd();
            $categColor[] = $categorie->getColor();
            $categCount[] = count($categorie->getProduits());
        }
 
        // On va chercher le nombre d'annonces publiées par date
        $annonces = $prodRepo->countByDate();
        
 
        $dates = [];
        $annoncesCount = [];
 
        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($annonces as $annonce){
            $dates[] = $annonce['dateAnnonces'];
            $annoncesCount[] = $annonce['count'];
        }
 
        return $this->render('categorie_prod/stats.html.twig', [
            'categNom' => json_encode($categNom),
            'categColor' => json_encode($categColor),
            'categCount' => json_encode($categCount),
            'dates' => json_encode($dates),
            'annoncesCount' => json_encode($annoncesCount),
        ]);
    }





    #[Route('/new', name: 'app_categorie_prod_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategorieProdRepository $categorieProdRepository): Response
    {
        $categorieProd = new CategorieProd();
        $form = $this->createForm(CategorieProdType::class, $categorieProd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si un nom de catégorie similaire existe déjà
            $existingCategorie = $categorieProdRepository->findOneBy(['categorie_prod' => $categorieProd->getCategorieProd()]);

            if ($existingCategorie) {
                $this->addFlash('error', 'Le nom de catégorie existe déjà.');
                return $this->redirectToRoute('app_categorie_prod_new');
            }

            $entityManager->persist($categorieProd);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_prod_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_prod/new.html.twig', [
            'categorie_prod' => $categorieProd,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_prod_show', methods: ['GET'])]
    public function show(CategorieProd $categorieProd): Response
    {
        return $this->render('categorie_prod/show.html.twig', [
            'categorie_prod' => $categorieProd,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_prod_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieProd $categorieProd, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieProdType::class, $categorieProd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_prod_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_prod/edit.html.twig', [
            'categorie_prod' => $categorieProd,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_prod_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieProd $categorieProd, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieProd->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorieProd);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_prod_index', [], Response::HTTP_SEE_OTHER);
    }



   



}