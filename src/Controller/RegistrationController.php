<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{

    public function __construct(
        private readonly JWTService $jWTService,
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly SendMailService $sendMail
    ) {}

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        UserAuthenticator $authenticator
        ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // do anything else you need here, like send an email

            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];

            $payload = [
                'userId' => $user->getId()
            ];

            $token = $this->jWTService->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            $this->sendMail->send(
                'contact@marinesanson.fr',
                $user->getEmail(),
                'Activation de votre compte sur le site Snowtricks',
                'register',
                [
                    'user' => $user,
                    'token' => $token
                ]
            );

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

    #[Route('/verify/{token}', name: 'verify_user')]
    public function verifyUser(string $token): Response
    {
        if($this->jWTService->isValid($token) && !$this->jWTService->isExpired($token) && $this->jWTService->check($token, $this->getParameter('app.jwtsecret'))) {
            $payload = $this->jWTService->getPayload($token);
            $user = $this->userRepository->find($payload['userId']);
            if ($user && !$user->getIsVerified()){
                $user->setIsVerified(true);
                $this->entityManager->flush();
                $this->addFlash('success', 'Utilisateur activé');
                return $this->redirectToRoute('home');
            }
        }
        $this->addFlash('danger', 'Le token est invalid ou a expiré');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/verifyagain', name: 'resend_verify')]
    public function resendVerify(): Response
    {
        $user = $this->getUser();

        if (!$user){
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }

        if ($user->getIsVerified()){
            $this->addFlash('warning', 'Cet utilisateur est déjà activé');
            return $this->redirectToRoute('app_login');
        }

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $payload = [
            'userId' => $user->getId()
        ];

        $token = $this->jWTService->generate($header, $payload, $this->getParameter('app.jwtsecret'));

        $this->sendMail->send(
            'contact@marinesanson.fr',
            $user->getEmail(),
            'Activation de votre compte sur le site Snowtricks',
            'register',
            [
                'user' => $user,
                'token' => $token
            ]
        );

        $this->addFlash('success', 'Email de vérification envoyé');
        return $this->redirectToRoute('app_login');

        }

    }
