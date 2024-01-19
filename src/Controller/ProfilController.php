<?php

namespace App\Controller;

use App\Entity\Media;
use DateTimeImmutable;
use App\Form\ProfilFormType;
use App\Service\MailService;
use App\Service\UserService;
use App\Service\MediaService;
use App\Service\ProfilService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/profil', name: 'app_admin_profil_')]
class ProfilController extends AbstractController
{
    public function __construct(
        private readonly MediaService $mediaService,
        private readonly ProfilService $profilService,
        private readonly UserService $userService,
        private readonly MailService $mailService
    ) {}

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->userService->getUser($this->getUser()->getUserIdentifier());
        if ($user->getAvatar() === null){
            $user->setAvatar($this->mediaService->getMediaByName('avatar_default.webp'));
        }

        return $this->render('/profil/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/maj', name: 'edit', methods: ['POST', 'GET'])]
    public function edit(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->userService->getUser($this->getUser()->getUserIdentifier());
        $oldUserame = $user->getUsername();
        $oldEmail = $user->getUserIdentifier();
        $oldAvatar = $user->getAvatar();
        $defaultAvatar =$this->mediaService->getMediaByName('avatar_default.webp');

        if ($oldAvatar === null){
            $user->setAvatar($defaultAvatar);
        }

        $profilForm = $this->createForm(ProfilFormType::class, $user);
        $profilForm->handleRequest($request);

        if($profilForm->isSubmitted() && $profilForm->isValid()){

            $user->setUpdatedAt(new DateTimeImmutable());

            $username = $profilForm->get('username')->getData();
            $email = $profilForm->get('email')->getData();
            $avatar = $profilForm->get('avatar')->getData();

            if ($username !== $oldUserame){
                $user->setUsername($username);
            }

            if ($email !== $oldEmail){
                $user->setEmail($email);
                $user->setIsVerified(false);
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
            }//end if

            if ($avatar){

                if (!$oldAvatar || $oldAvatar !== $avatar){
                    $avatar = $this->mediaService->addNewImage($avatar, 'avatars', 'avatar');
                    $user->setAvatar($avatar);
                }
                if ($oldAvatar !== null && $oldAvatar->getName() !== $defaultAvatar->getName()) {
                    $this->mediaService->deleteMediaImage($oldAvatar, 'avatars');
                }

            }

            $user = $this->userService->saveUser($user);

            $this->addFlash('success', 'Profil modifié avec succes');
            return $this->render('profil/index.html.twig', [
                'user' => $user
            ]);
        }

        return $this->render('profil/edit.html.twig', [
            'profilForm' => $profilForm->createView(),
            'user' => $user
        ]);

    }

    #[Route('/suppression/media/{id}', name: 'delete_media', methods: ['GET'])]
    public function deleteImage(int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $media = new Media;
        $media = $this->mediaService->getMedia($id);
        $deleted = $this->mediaService->deleteMedia($media);
        
        if ($deleted) {
            $this->addFlash('success', 'Media supprimé avec succes');
            return $this->render('admin_tricks/index.html.twig');
        }

        $this->addFlash('danger', 'Un problème est survenu');
        return $this->render('admin_tricks/index.html.twig');
    }

}
