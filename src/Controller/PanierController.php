<?php

namespace App\Controller;
use App\Repository\ProduitRepository;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier_index', methods: ['GET'])]public function index(PanierRepository $panierRepository, EntityManagerInterface $entityManager): Response
    {
       # $produitIds = [3, 6, 4 ,2];
      
    $panierId=1;
    $produitsIds = $panierRepository->getProduitsIdArrayById($panierId);
       # $panier = new Panier(); // Assuming you are creating a new panier
       $panier = $entityManager->getRepository(Panier::class)->findPanierById($panierId);
        $panier->setTotalPrix(1);
        $entityManager->persist($panier);
        $entityManager->flush();
        foreach ($produitsIds as $produitId) {
            $produit = $entityManager->getRepository(Produit::class)->find($produitId);
            if ($produit) {
                $panier->addProduit($produit);
            }
        }
        $entityManager->persist($panier);
        $entityManager->flush();
        $produits = $panier->getProduits();
    
        return $this->render('panier/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/indexadmin', name: 'app_panier_index_admin', methods: ['GET'])]
    public function indexadmin(PanierRepository $panierRepository): Response
    {
        return $this->render('panier/index_panier_admin.html.twig', [
            'paniers' => $panierRepository->findAll(),
        ]);
    }

  



    #[Route('/new', name: 'app_panier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_show', methods: ['GET'])]
    public function show(Panier $panier): Response
    {
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(ProduitRepository $produitRepository,Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->render('produits/index.html.twig', ['produits' => $produitRepository->findAll(),]);
    }
    
    #[Route('/', name: 'app_ajouter_panier', methods: ['GET'])]
    public function ajouterPanier(EntityManagerInterface $entityManager, $produit_id): Response
    {
        $produit = $entityManager->getRepository(Produit::class)->find($produit_id);
        if (!$produit) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }
    
        $panier_id = 1;
        $panier = $entityManager->getRepository(Panier::class)->find($panier_id);
    
        // Vérifier si le produit existe déjà dans le panier
        $produitsId = $panier->getProduitsId() ?? [];
        if (in_array($produit->getId(), $produitsId)) {
            $this->addFlash('info', 'Le produit est déjà dans le panier.');
            return $this->render('produits/show.html.twig', [
                'produit' => $produit,
            ]);
        }
    
        $produitsId[] = $produit->getId();
        $panier->setProduitsId($produitsId);
        $entityManager->flush();
    
        $this->addFlash('success', 'Le produit a été ajouté au panier avec succès.');
    
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }
    

    #[Route('/delete-panier/{produit_id}', name: 'app_delete_produit_from_panier', methods: ['GET'])]

public function deleteProduitFromPanier(PanierRepository $panierRepository, int $produit_id): Response
{
    $panierId = 1; // Assuming you want to delete from a specific panier

    // Remove produit_id from panier
    $panierRepository->removeProduitIdFromPanier($panierId, $produit_id);

    // Redirect or render a response as needed
    return $this->redirectToRoute('app_panier_index');
}
    

}
