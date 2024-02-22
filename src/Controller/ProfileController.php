<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; // Corrected namespace import
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;



class ProfileController extends AbstractController 


{
    /**
 * @Route("/edit", name="User.edit", methods={"GET", "POST"})
 */


    #[Route('/edit', name: 'User.edit', methods: ['GET', 'POST'])]
    public function editProfile(Request $request , ManagerRegistry $Manag)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $Manag->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');
            
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
