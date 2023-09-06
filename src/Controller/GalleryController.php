<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Form\GalleryFormType;
use App\Repository\GalleryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GalleryController extends AbstractController
{
    #[Route('/galerie', name: 'app_gallery')]
    public function galerie(GalleryRepository $galleries): Response
    {
        $pictures = $galleries->findBy([], ['id' => 'DESC']);
        return $this->render('pages/gallery/galerie.html.twig', [
            'galleries' => $pictures
        ]);
    }

    #[Route('/galerie/ajouter', name: 'app_add_gallery')]
    public function addGalerie(Request $request, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $gallery = new Gallery();
        $form = $this->createForm(GalleryFormType::class, $gallery);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (($this->getUser()->getPseudo() != null)) {
                $gallery->setAuthor($this->getUser()->getPseudo());
            } else {
                $gallery->setAuthor($this->getUser()->getFirstName());
            }
            $gallery->setAuthorId($this->getUser()->getId());
            $manager->persist($gallery);
            $manager->flush();
            $this->addFlash(
                'success',
                'Image ajouté avec succès !'
            );
            return $this->redirectToRoute('app_gallery');
        }
        return $this->render('pages/gallery/newgalerie.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/galerie/suppression/{id}', name: 'gallery_delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Gallery $picture): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->getUser()->getId() != $picture->getAuthorId()) {
            return $this->redirectToRoute("app_login");
        }
        $manager->remove($picture);
        $manager->flush();

        $this->addFlash(
            'delete',
            'Photo supprimé avec succès'
        );

        return $this->redirectToRoute('app_gallery');
    }
}
