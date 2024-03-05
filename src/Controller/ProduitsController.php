<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieProdRepository;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/produits')]
class ProduitsController extends AbstractController
{

    #[Route('/', name: 'app_produits_index', methods: ['GET'])]
    public function index(Request $request, ProduitRepository $produitRepository, CategorieProdRepository $categorieProdRepository, PaginatorInterface $paginator): Response
    {
        $idCat = $request->query->get('idCat');
        $searchTerm = $request->query->get('search');
    
        if ($idCat) {
            $category = $categorieProdRepository->find($idCat);
    
            if (!$category) {
                throw $this->createNotFoundException('Catégorie non trouvée');
            }
    
            if ($searchTerm) {
                $query = $produitRepository->searchInCategory($category, $searchTerm);
            } else {
                $query = $produitRepository->findBy(['idCat' => $category]);
            }
        } else {
            if ($searchTerm) {
                $query = $produitRepository->findAllWithSearch($searchTerm);
            } else {
                $query = $produitRepository->findAll();
            }
        }
    
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );
    
        return $this->render('produits/index.html.twig', [
            'pagination' => $pagination,
            'categories' => $categorieProdRepository->findAll(),
        ]);
    }

    
     #[Route('/AjoutDon', name: 'app_produit_ajoutDon', methods: ['GET'])]
    public function AjoutDon(): Response
    {
        return $this->render('produits/AjoutDon.html.twig');
    }

    #[Route('/ProduitAdmin', name: 'app_produit_produitAdmin', methods: ['GET'])]
    public function ProduitAdmin(ProduitRepository $produitRepository): Response
    {
        return $this->render('produits/produitAdmin.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }




    #[Route('/thanks', name: 'app_produit_thanks', methods: ['GET'])]
    public function Thanks(): Response
    {
        return $this->render('produits/Thanks.html.twig');
    }

    #[Route('/userProducts', name: 'app_produits_userProducts', methods: ['GET'])]
    public function userProduct(ProduitRepository $produitRepository): Response
    {
        return $this->render('produits/userProducts.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
            $file = $form['photoProd']->getData();
    
            if ($file instanceof UploadedFile) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $produit->setPhotoProd($fileName);
            } else {
                $produit->setPhotoProd('7a6c6cc4df05258781e29ef7c08cf4b7.jpg');
            }
            if ($produit->getTypeProd() === 'Don') {
                $produit->setPrixProd(0);
            }
            $produit->setCreatedAtValue();
    
            $entityManager->persist($produit);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_produit_thanks', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('produits/new.html.twig', [
            'produit' => $produit,
            'f' => $form,
        ]);
    }
    

  

    #[Route('/{id}', name: 'app_produits_show', methods: ['GET'])]
public function show(Produit $produit, Request $request): Response
{
    $referer = $request->headers->get('referer');
    
    if (strpos($referer, '/produits/ProduitAdmin') !== false) {
        return $this->render('produits/ShowProduitAdmin.html.twig', [
            'produit' => $produit,
        ]);
    } elseif (strpos($referer, '/produits/userProducts') !== false) {
        return $this->render('produits/showUserProducts.html.twig', [
            'produit' => $produit,
        ]);
    } else {
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }
}
    

    

  

    

    #[Route('/{id}/edit', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $referer = $request->headers->get('referer');

        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        if (strpos($referer, '/produits/ProduitAdmin') !== false) {
            return $this->redirectToRoute('app_produit_produitAdmin', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}


















