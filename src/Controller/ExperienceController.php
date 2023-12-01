<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Entity\Upload;
use App\Form\ExperienceType;
use App\Repository\ExperienceRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/experiences', name: 'experience_')]
class ExperienceController extends AbstractController
{
	#[Route('/new', name: 'new')]
	public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
	{
		$experience = new Experience();
		$form = $this->createForm(ExperienceType::class, $experience);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$file = $form->get('file')->getData();
			if ($file) {
				$upload = new Upload();
				$uploadFileName = $fileUploader->upload($file);
				$upload->setFileName($uploadFileName);
				$experience->setImage($uploadFileName);
			}

			$entityManager->persist($experience);
			$entityManager->flush();

			$this->addFlash('success', "This work experience has been successfully created");
			$this->addFlash('success', "« #" . $experience->getId() . " - " . $experience->getName() . " »");
			return $this->redirectToRoute('app_home');
		}

		return $this->render('experience/index.html.twig', [
			'experienceForm' => $form,
		]);
	}

	#[Route('/{id}', name: 'edit')]
	public function edit(int $id, Request $request, ExperienceRepository $experienceRepository, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
	{
		$experience = $experienceRepository->find($id);
		$form = $this->createForm(ExperienceType::class, $experience);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$file = $form->get('file')->getData();
			if ($file) {
				$upload = new Upload();
				$uploadFileName = $fileUploader->upload($file);
				$upload->setFileName($uploadFileName);
				$experience->setImage($uploadFileName);
			}

			$entityManager->persist($experience);
			$entityManager->flush();

			$this->addFlash('success', "This work experience has been successfully edited");
			$this->addFlash('success', "« #" . $experience->getId() . " - " . $experience->getName() . " »");
			return $this->redirectToRoute('app_home');
		}

		return $this->render('experience/index.html.twig', [
			'experienceForm' => $form,
		]);
	}

	#[Route('/remove/{id}', name: 'remove')]
	public function remove(int $id, EntityManagerInterface $entityManager, ExperienceRepository $experienceRepository): Response
	{
		$experience = $experienceRepository->find($id);

		$entityManager->remove($experience);
		$entityManager->flush();

		$this->addFlash('success', "This work experience has been successfully removed");
		$this->addFlash('success', "« #" . $experience->getId() . " - " . $experience->getName() . " »");
		return $this->redirectToRoute('app_home');
	}
}
