<?php 

namespace App\Mail;

use App\Entity\Newsletter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NewsletterSubscribedConfirmation {
    public function __construct(private MailerInterface $mailer, private string $adminEmail) { 

    }
    public function sendEmail(Newsletter $newsletter){
         //envoyer un email de confirmation
            // Construire le message
            $email = (new Email())
            ->from('admin@hbft10.fr')
            ->to($newsletter->getEmail())
            ->subject('Welcome!')
            ->text('Your email ' . $newsletter->getEmail() . ' has been successfully registered for the newsletter.')
            ->html('<p>Your Email' . $newsletter->getEmail() . ' has been successfully registered for the newsletter.</p>');

            // Envoyer le message
            $this->mailer->send($email);
    }
}