<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class ContactNotification
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(MailerInterface $mailer, Environment $renderer)
    {

        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
        $email = (new Email())
            ->subject('Agence : ' . $contact->getProperty()->getTitle())
            ->from('noreply@server.com')
            ->to('contact@agence.fr')
            ->replyTo($contact->getEmail())


            ->html($this->renderer->render(
                'emails/contact.html.twig',
                ['contact' => $contact]
            ), 'text/html');

        $this->mailer->send($email);
    }
}
