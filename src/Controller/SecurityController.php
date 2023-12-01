<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
	#[Route(path: '/login', name: 'app_login')]
	public function login(AuthenticationUtils $authenticationUtils): Response
	{
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('security/login.html.twig', [
			'last_username' => $lastUsername,
			'error' => $error,
		]);
	}

	#[Route(path: '/logout', name: 'app_logout')]
	public function logout(): void
	{
		throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
	}

	#[Route(path: '/user', name: 'app_user')]
	public function user(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, FileUploader $fileUploader): Response
	{
		$user = $userRepository->find($this->getUser());

		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$password = $form->get('newPassword')->getData();

			if ($password) {
				$user->setPassword($userPasswordHasher->hashPassword($user, $password));
			}

			$file = $form->get('file')->getData();
			if ($file) {
				$upload = new Upload();
				$uploadFileName = $fileUploader->upload($file);
				$upload->setFileName($uploadFileName);
				$user->setAvatar($uploadFileName);
			}

			$entityManager->persist($user);
			$entityManager->flush();

			$this->addFlash('success', "Your account has been edited");
			return $this->redirectToRoute('app_home');
		}

		return $this->render('security/index.html.twig', [
			'userForm' => $form,
			'user' => $user,
		]);
	}
}