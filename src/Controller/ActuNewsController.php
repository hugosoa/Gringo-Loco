<?php

namespace App\Controller;

use App\Entity\ActuNews;
use App\Form\ArticlesType;
use App\Repository\ActuNewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ActuNewsController extends AbstractController
{

    #[Route('/actualites', name: 'app_actualites', methods: ['GET'])]
    public function index(ActuNewsRepository $actunews, PaginatorInterface $paginator, Request $request): Response
    {

        $articles = $paginator->paginate(
            $actunews->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('pages/actunews/actualites.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * this controller show a form wich create an article
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/actualites/nouveau', name: 'actualites.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $article = new ActuNews();
        $form = $this->createForm(ArticlesType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (($this->getUser()->getPseudo() != null)) {
                $article->setAuthor($this->getUser()->getPseudo());
            } else {
                $article->setAuthor($this->getUser()->getFirstName());
            }
            $article->setAuthorId($this->getUser()->getId());
            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                'Article ajouté avec succès !'
            );

            return $this->redirectToRoute('app_actualites');
        }
        return $this->render('pages/actunews/newarticle.html.twig', [
            'form' => $form->createView()
        ]);
    }



    #[Route('/actualites/edition/{id}', name: 'actualites.edit', methods: ['GET', 'POST'])]
    public function edit(ActuNewsRepository $repository, int $id, Request $request, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $article = $repository->findOneBy(["id" => $id]);
        if ($this->getUser()->getId() != $article->getAuthorId()) {
            return $this->redirectToRoute("app_login");
        }


        $form = $this->createForm(ArticlesType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'edit',
                'Article modifié avec succès !'
            );

            return $this->redirectToRoute('app_actualites');
        }


        return $this->render('pages/actunews/editarticle.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/actualites/suppression/{id}', name: 'actualites.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, ActuNews $article): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->getUser()->getId() != $article->getAuthorId()) {
            return $this->redirectToRoute("app_login");
        }
        $manager->remove($article);
        $manager->flush();

        $this->addFlash(
            'delete',
            'Article supprimé avec succès'
        );

        return $this->redirectToRoute('app_actualites');
    }

    #[Route('/actualites/articles/{id}', name: 'app_article')]
    public function article(int $id, ActuNewsRepository $repository)
    {
        $article = $repository->findOneBy(["id" => $id]);
        return $this->render('pages/actunews/article.html.twig', [
            'article' => $article
        ]);
    }
}
