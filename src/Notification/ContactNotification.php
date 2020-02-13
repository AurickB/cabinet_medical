<?php

namespace App\Notification;

use App\Entity\Contact;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactNotification extends AbstractController {


    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify (Contact $contact){

        $message = (new \Swift_Message('Prise de contact - Cabinet médical : '))
            ->setfrom($contact->getEmail())
            ->setto($contact->getUserMail())
            ->setreplyTo($contact->getEmail())
            ->setBody($this->renderer->render('email/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);
    }
}