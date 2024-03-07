<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppAuthAuthenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\Security\Core\Security;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;



class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthAuthenticator $authenticator, EntityManagerInterface $entityManager , MailerInterface $mailer,Security $security): Response
    {
        if ($this->getUser()) {
			return $this->redirectToRoute('app_global');
		}

        // Génération du nonce pour le script reCAPTCHA

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $user->setroles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();
            


           /* $email = (new Email())
            ->from('Shaima.BenNourddine@esprit.tn')
            ->to($user->getEmail())
            ->subject('test');
            ->text('tets')
            ->html('registration/confirmation_email.html.twig');
       */
                //$mailer->send($email); 

            // generate a signed url and email it to the user
              
             
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
    (new TemplatedEmail())
        ->from(new Address('Shaima.BenNourddine@esprit.tn', 'Traskel Mail bot'))
        ->to($user->getEmail())
        ->subject('Thank you for registering with Traskel! Please confirm your email to activate your account.')
        ->htmlTemplate('registration/confirmation_email.html.twig')
);

            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_global');
    }
}