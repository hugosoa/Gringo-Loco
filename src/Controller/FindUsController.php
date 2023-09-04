<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FindUsController extends AbstractController
{
    #[Route('/nous-trouver', name: 'app_find_us')]
    public function index(): Response
    {
        return $this->render('pages/findus/findus.html.twig', [
            'controller_name' => 'FindUsController',
        ]);
    }
}
