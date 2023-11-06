<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function add(EntityManagerInterface $manager, Request $request): Response
    {
        $contact = new Contact();

        $form_contact = $this->createForm(ContactType::class, $contact);
        $form_contact->handleRequest($request);

        if ($form_contact->isSubmitted() && $form_contact->isValid()) {

            $manager->persist($contact);
            $manager->flush();
        }

        return $this->render('contact/index.html.twig', [
            'form_contact' => $form_contact->createView(),
        ]);
    }
}
