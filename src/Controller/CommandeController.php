<?php

namespace App\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    #[Route('/indexadmin', name: 'app_commande_index', methods: ['GET'])]
    public function indexAdmin(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index_commande_admin.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $total_price = $request->query->get('total_price');
        $adresse = $request->query->get('adresse');
        $delais_Cmd= $request->query->get('delais_Cmd');
        $commande = new Commande();
        $commande->setPrixCmd($total_price);
        $commande->setAdresseCmd($adresse);
        $commande->setStatutCmd("EnCours");
        $commande->setDelaisCmd($delais_Cmd);
        $entityManager->persist($commande);
        $entityManager->flush();
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }
  

    #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/showadmin/{id}', name: 'app_commande_showadmin', methods: ['GET'])]
    public function showAdmin(Commande $commande): Response
    {
        return $this->render('commande/showAdmin.html.twig', [
            'commande' => $commande,
        ]);
    }

    
    #[Route('/imp/{id}', name: 'app_commande_imprimer', methods: ['POST', 'GET'])]
    public function showImp(Commande $commande): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
    
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
    
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('commande/showimp.html.twig', [
            'commande' => $commande
        ]);
    
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
    
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
    
        // Render the HTML as PDF
        $dompdf->render();
    
        // Output the generated PDF to Browser (inline display)
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="mypdf.pdf"');
    
        // Save the PDF file to the public directory
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public';
        $pdfFilepath = $publicDirectory . '/mypdf.pdf';
        file_put_contents($pdfFilepath, $dompdf->output());
    
        // Return the PDF as the response
        return $response;
    }

    #[Route('/{id}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/thanks', name: 'app_produit_thanks', methods: ['GET'])]
    public function Thanks(): Response
    {
        return $this->render('commande/Thanks.html.twig');
    }
}
