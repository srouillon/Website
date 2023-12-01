<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
	#[Route('/contact', name: 'app_contact')]
	public function index(Request $request, MailService $mailService, EntityManagerInterface $entityManager): Response
	{
		$contact = new Contact();
		$form = $this->createForm(ContactType::class, $contact);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid() && $request->request->get('check') === 'on') {
			$sujet = $contact->getObject();
			$senderEmail = $contact->getEmail();
			$senderName = $contact->getIdentity();
			$message = nl2br($contact->getMessage());
			$mailService->sendMail($senderEmail, $senderName, "contact@srouillon.fr", $sujet, $message);

			$entityManager->persist($contact);
			$entityManager->flush();

			$this->addFlash('success', "Un nouveau mail a été envoyé !");
			return $this->redirectToRoute('app_home');
		}

		return $this->render('contact/index.html.twig', [
			'contactForm' => $form,
		]);
	}
}
