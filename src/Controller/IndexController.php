<?php

namespace App\Controller;

use App\Mail\NewsletterSubscribedConfirmation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\NewsletterType;
use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        return $this->render('index/home.html.twig');
    }

    #[Route('/shop', name: 'app_shop')]
    public function shop(): Response
    {
        return $this->render('index/shop.html.twig');
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        $authorsNames = [
            'John Doe',
            'Jane Smith',
            'Alice Johnson',
            'Bob Brown'
        ];
        return $this->render('index/about.html.twig', [
            'authors' => $authorsNames,
        ]);
    }

    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('index/article.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //enregistrer le message dans la base de données
            $em->persist($contact);
            $em->flush();

            //envoyer un email de confirmation
            // Construire le message
            // $email = (new Email())
            // ->from('admin@hbft10.fr')
            // ->to($contact->getEmail())
            // ->subject('Welcome!')
            // ->text('Your email ' . $contact->getEmail() . ' has been successfully registered for the newsletter.')
            // ->html('<p>Your Email' . $contact->getEmail() . ' has been successfully registered for the newsletter.</p>');

            // // Envoyer le message
            // $mailer->send($email);

            // Ajouter un message flash
            $this->addFlash('success', 'You have successfully sent your mail.');
        }
        return $this->render('index/contact.html.twig', [
        'contactForm' => $form 
    ]);
    }

    #[Route('/newsletter', name: 'app_newsletter_subscribe')]
    public function subscribe(Request $request, EntityManagerInterface $em, NewsletterSubscribedConfirmation $confirmationService): Response
    {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //enregistrer l'email dans la base de données
            $em->persist($newsletter);
            $em->flush();

            $confirmationService->sendEmail($newsletter);
            // Ajouter un message flash
            $this->addFlash('success', 'You have successfully subscribed to the newsletter!. You will receive a confirmation email shortly.');
        }
        return $this->render('index/subscribe.html.twig', [
            'newsletterForm' => $form
        ]);
    }
}

