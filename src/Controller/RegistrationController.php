<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\UserRegister;
use App\Service\JWTService;
use App\Service\MailService;
use App\Service\UserService;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{

    public function __construct(
        private readonly JWTService $jWTService,
        private readonly MailService $mailService,
        private readonly UserService $userService
    ) {}

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRegister = new UserRegister($form->get('username')->getData(), $form->get('email')->getData(), $form->get('plainPassword')->getData());

            $token = $this->userService->register($userRegister);

            $this->mailService->send(
                'contact@marinesanson.fr',
                $user->getEmail(),
                'Activation de votre compte sur le site Snowtricks',
                'register',
                [
                    'user' => $user,
                    'token' => $token
                ]
            );

            $this->addFlash('warning', 'Vérifiez vos emails pour valider votre compte');
            return $this->redirectToRoute('home');

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/{token}', name: 'verify_user', methods: ['GET', 'POST'])]
    public function verifyUser(
        string $token,
        Request $request,
        UserAuthenticatorInterface $userAuthenticator,
        UserAuthenticator $authenticator
    ): Response
    {
        if($this->jWTService->isValid($token) && !$this->jWTService->isExpired($token) && $this->jWTService->check($token, $this->getParameter('app.jwtsecret'))) {
            $payload = $this->jWTService->getPayload($token);

            $userVerified = $this->userService->getUserVerified($payload['userId']);

            if ($userVerified){
              
                $this->addFlash('success', 'Utilisateur activé');
                return $userAuthenticator->authenticateUser(
                    $userVerified,
                    $authenticator,
                    $request
                );
            }
            $this->addFlash('warning', 'Cet utilisateur est déjà activé');
            return $this->redirectToRoute('app_login');
        }
        $this->addFlash('danger', 'Le token est invalid ou a expiré');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/reverifier', name: 'resend_verify', methods: ['GET'])]
    public function resendVerify(): Response
    {
        $user = $this->getUser();

        if (!$user){
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }

        $isUserVerifiedYet = $this->userService->isUserVerifiedYet($user);

        if ($isUserVerifiedYet){
            $this->addFlash('warning', 'Cet utilisateur est déjà activé');
            return $this->redirectToRoute('app_login');
        }

        $userModel = $this->userService->getUserModel($user);

        $token = $this->userService->newRegisterToken($userModel);

        $this->mailService->send(
            'contact@marinesanson.fr',
            $userModel->getEmail(),
            'Activation de votre compte sur le site Snowtricks',
            'register',
            [
                'user' => $userModel,
                'token' => $token
            ]
        );

        $this->addFlash('success', 'Email de vérification envoyé');
        return $this->redirectToRoute('app_login');
    }

}
