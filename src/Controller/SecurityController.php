<?php

/**
 * SecurityController File Doc Comment
 *
 * @category Controller
 * @package  App\Controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Controller;

use App\Service\MailService;
use App\Service\UserService;
use App\Form\ResetPasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * SecurityController Class Doc Comment
 *
 * @category Controller
 * @package  App\Controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class SecurityController extends AbstractController
{


    /**
     * Summary of function __construct
     *
     * @param UserService                 $userService       UserService
     * @param MailService                 $mailService       MailService
     * @param UserPasswordHasherInterface $userPasswordHasher UserPasswordHasherInterface
     */
    public function __construct(
        private readonly UserService $userService,
        private readonly MailService $mailService,
        private readonly UserPasswordHasherInterface $userPasswordHasher
    ) {

    }


    /**
     * Summary of function login
     *
     * Verify the data send by the user to log him
     *
     * @param AuthenticationUtils $authenticationUtils AuthenticationUtils
     *
     * @return Response
     */
    #[Route(path: '/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // Get the login error if there is one.
        $error = $authenticationUtils->getLastAuthenticationError();
        // Last username entered by the user.
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);

    }


    /**
     * Summary of function logout
     *
     * Logout the user
     * 
     * @return void
     */
    #[Route(path: '/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }


    /**
     * Summary of function forgottenPassword
     *
     * Send an email to the user with a token to reset his password
     *
     * @param Request $request Request
     *
     * @return Response
     */
    #[Route(path: '/oubli-mdp', name: 'forgotten_password', methods: ['GET', 'POST'])]
    public function forgottenPassword(Request $request): Response
    {

        $form = $this->createForm(ResetPasswordRequestFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userKnown = $this->userService->isUserKnown($form->get('email')->getData());

            if ($userKnown !== null) {
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

            $this->addFlash('danger', 'Cette adresse mail est inconnue');
            return $this->redirectToRoute('app_login');
        } //end if

        return $this->render(
            'security/reset_password_request.html.twig', [
                'requestPassForm' => $form->createView()
            ]
        );

    }


    /**
     * Summary of function resetPassword
     *
     * Verify the token send to the user to see if his email adress is true
     * and reset his password
     *
     * @param string  $token   Token
     * @param Request $request Request
     *
     * @return Response
     */
    #[Route(path: '/oubli-mdp/{token}', name: 'reset_password', methods: ['GET', 'POST'])]
    public function resetPassword(string $token, Request $request): Response
    {

        $userModel = $this->userService->findUserByResetToken($token);

        if ($userModel !== null) {
            $form = $this->createForm(ResetPasswordFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->userService->setNewPassword($userModel, $form->get('password')->getData());

                $this->addFlash('success', 'Mot de passe changé avec succes');
                return $this->redirectToRoute('app_login');
            }

            return $this->render(
                'security/reset_password.html.twig', [
                    'passForm' => $form->createView()
                ]
            );
        }

        $this->addFlash('danger', 'Jeton invalide');
        return $this->redirectToRoute('app_login');

    }


}
