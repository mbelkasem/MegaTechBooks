<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(HttpFoundationRequest $request, MailerInterface $mailer): Response
    {
        $contactForm = $this->createForm(ContactType::class);

        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
           $address = $contactForm->get('email')->getData();
           $subject = $contactForm->get('subject')->getData();
           $content = $contactForm->get('content')->getData();

           $email = (new Email())
            ->from($address)
            ->to('contact@megatechbooks.be')          
            ->subject($subject)
            ->text($content);
            

            $mailer->send($email);

            $this->addFlash('success', 'Email envoyé ');
            return $this->redirect('/'); 
        }
       
       
        return $this->render('contact/index.html.twig', [
            'form' => $contactForm->createView(),
        ]);
    }
}
