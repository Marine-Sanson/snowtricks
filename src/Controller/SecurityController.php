<?php

namespace App\Controller;

use App\Service\MailService;
use App\Service\UserService;
use App\Form\ResetPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly EntityManagerInterface $entityManager,
        private readonly MailService $mailService,
        private readonly UserPasswordHasherInterface $userPasswordHasher
    ) {}

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/oubli-mdp', name: 'forgotten_password')]
    public function forgottenPassword(Request $request): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $userKnown = $this->userService->isUserKnown($form->get('email')->getData());

            if($userKnown){
                $token = $this->userService->setToken($userKnown);

                $this->mailService->send(
                    'contact@marinesanson.fr',
                    $userKnown->getEmail(),
                    'Réinitialisation du mot de passe',
                    'password_reset',
                    [
                        'token' => $token,
                        'user' => $userKnown
                    ]
                );

                $this->addFlash('success', 'Email envoyé');
                return $this->redirectToRoute('app_login');
    
            }
            $this->addFlash('danger', 'Un problème est survenu');
            return $this->redirectToRoute('app_login');

        }

        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }

    #[Route(path: '/oubli-mdp/{token}', name: 'reset_password')]
    public function resetPassword(string $token, Request $request): Response
    {
        $userModel = $this->userService->findUserByResetToken($token);

        if($userModel){
            $form = $this->createForm(ResetPasswordFormType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $this->userService->setNewPassword($userModel, $form->get('password')->getData());

                $this->addFlash('success', 'Mot de passe changé avec succes');
                return $this->redirectToRoute('app_login');
            }

            return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);
        }
        $this->addFlash('danger', 'Jeton invalide');
        return $this->redirectToRoute('app_login');
    }

}
