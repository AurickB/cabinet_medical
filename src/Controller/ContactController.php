<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @param Request $request
     * @param ContactNotification $notification
     * @return Response
     * @Route("/contact", name="contact")
     */
    public function index (Request $request, ContactNotification $notification): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $notification->notify($contact); // Ici on gère la partie de traitement du mail
            $this->addFlash('success', 'Votre emails a bien été envoyé');
            return $this->redirectToRoute('contact');
        }
        return $this->render('pages/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}