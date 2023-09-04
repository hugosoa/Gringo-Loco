<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Component\Mime\Email;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function sendEmail(MailerInterface $mailer, Request $request, EntityManagerInterface $manager): Response
    {
        $reservation = new Reservation();

        if ($this->getUser()) {
            $reservation->setFullName($this->getUser()->getLastName())
                ->setEmail($this->getUser()->getEmail());
        }
        $form  = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();

            $manager->persist($reservation);
            $manager->flush();

            $this->addFlash(
                'success',
                'Demande de réservation bien envoyé'
            );
            $email = (new Email())
                ->from($reservation->getEmail())
                ->to('admin@gringoloco.com')
                ->html($reservation->getContent());

            $mailer->send($email);
            return $this->redirectToRoute('app_reservation');
        }

        // ...
        return $this->render('pages/reservation/reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
