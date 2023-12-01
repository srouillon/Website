<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Upload;
use App\Form\CompetenceType;
use App\Repository\CompetenceRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/competences', name: 'competence_')]
class CompetenceController extends AbstractController
{
	#[Route('/new', name: 'new')]
	public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
	{
		$competence = new Competence();
		$form = $this->createForm(CompetenceType::class, $competence);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$file = $form->get('file')->getData();
			if ($file) {
				$upload = new Upload();
				$uploadFileName = $fileUploader->upload($file);
				$upload->setFileName($uploadFileName);
				$competence->setImage($uploadFileName);
			}

			$entityManager->persist($competence);
			$entityManager->flush();

			$this->addFlash('success', "This skill has been successfully created");
			$this->addFlash('success', "« #" . $competence->getId() . " - " . $competence->getName() . " »");
			return $this->redirectToRoute('app_home');
		}

		return $this->render('competence/index.html.twig', [
			'competenceForm' => $form,
		]);
	}

	#[Route('/edit/{id}', name: 'edit')]
	public function edit(int $id, Request $request, EntityManagerInterface $entityManager, CompetenceRepository $competenceRepository, FileUploader $fileUploader): Response
	{
		$competence = $competenceRepository->find($id);
		$form = $this->createForm(CompetenceType::class, $competence);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$file = $form->get('file')->getData();
			if ($file) {
				$upload = new Upload();
				$uploadFileName = $fileUploader->upload($file);
				$upload->setFileName($uploadFileName);
				$competence->setImage($uploadFileName);
			}

			$entityManager->persist($competence);
			$entityManager->flush();

			$this->addFlash('success', "This skill has been successfully edited");
			$this->addFlash('success', "« #" . $competence->getId() . " - " . $competence->getName() . " »");
			return $this->redirectToRoute('app_home');
		}

		return $this->render('competence/index.html.twig', [
			'competenceForm' => $form,
			'competence' => $competence,
		]);
	}

	#[Route('/remove/{id}', name: 'remove')]
	public function remove(int $id, EntityManagerInterface $entityManager, CompetenceRepository $competenceRepository): Response
	{
		$competence = $competenceRepository->find($id);
		$entityManager->remove($competence);
		$entityManager->flush();

		$this->addFlash('success', "This skill has been successfully removed");
		$this->addFlash('success', "« #" . $competence->getId() . " - " . $competence->getName() . " »");
		return $this->redirectToRoute('app_home');
	}
}