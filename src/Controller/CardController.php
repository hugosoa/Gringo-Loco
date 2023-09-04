<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route('/carte', name: 'app_card')]
    public function index(): Response
    {
        return $this->render('pages/card/card.html.twig', [
            'controller_name' => 'CardController',
        ]);
    }
}
