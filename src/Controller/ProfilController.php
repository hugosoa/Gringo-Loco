<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserFormType;
use App\Form\EditUserPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilController extends AbstractController
{
    #[Route('/profil', 'app_profil')]
    public function profil()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_register');
        }
        return $this->render(
            'pages/user/profil.html.twig',
            [
                'user' => $this->getUser()
            ]
        );
    }

    #[Route('/profil/editer', name: 'app_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            if ($user->getImageFile()) {
                // This is where you might handle image updates
            }

            $this->addFlash('success', 'Vos informations ont bien été mises à jour');
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_profil');
        }

        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/profil/editer/motdepasse', name: 'app_edit_password')]
    public function editPassword(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $form = $this->createForm(EditUserPasswordFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();
            $confirmPassword = $form->get('confirmPassword')->getData();
            if ($userPasswordHasher->isPasswordValid($user, $oldPassword)) {
                if ($newPassword == $confirmPassword) {
                    $this->addFlash(
                        'success',
                        'Mot de passe mis à jour'
                    );
                    $user->setPassword($userPasswordHasher->hashPassword($user, $newPassword));
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $this->redirectToRoute('app_profil');
                } else {
                    $this->addFlash(
                        'warning',
                        'Les mot de passe ne correspondent pas'
                    );
                }
            } else {
                $this->addFlash(
                    'warning',
                    'Mot de passe actuel invalide '
                );
            }
        }


        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/profil/suppression/image/{id}', name: 'pp_delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, User $user): Response
    {

        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'delete',
            'Photo de profil supprimée avec succès'
        );

        return $this->redirectToRoute('app_profil');
    }

    public function infoHeader()
    {
        return $this->render(
            'partials/_infos.html.twig',
            [
                'user' => $this->getUser()
            ]
        );
    }
}
