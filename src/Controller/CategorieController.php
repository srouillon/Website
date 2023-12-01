<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'categorie_')]
class CategorieController extends AbstractController
{
	#[Route('/new', name: 'new')]
	public function new(Request $request, EntityManagerInterface $entityManager): Response
	{
		$categorie = new Categorie();
		$form = $this->createForm(CategorieType::class, $categorie);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->persist($categorie);
			$entityManager->flush();

			$this->addFlash('success', "This category has been successfully created");
			$this->addFlash('success', "« #" . $categorie->getId() . " - " . $categorie->getName() . " »");
			return $this->redirectToRoute('app_home');
		}

		return $this->render('categorie/index.html.twig', [
			'categorieForm' => $form,
		]);
	}

	#[Route('/{id}', name: 'edit')]
	public function edit(int $id, Request $request, EntityManagerInterface $entityManager, CategorieRepository $competenceCategorieRepository): Response
	{
		$categorie = $competenceCategorieRepository->find($id);
		$form = $this->createForm(CategorieType::class, $categorie);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->persist($categorie);
			$entityManager->flush();

			$this->addFlash('success', "This category has been successfully edited");
			$this->addFlash('success', "« #" . $categorie->getId() . " - " . $categorie->getName() . " »");
			return $this->redirectToRoute('app_home');
		}

		return $this->render('categorie/index.html.twig', [
			'categorieForm' => $form,
			'id' => $id,
		]);
	}

	#[Route('/remove/{id}', name: 'remove')]
	public function remove(int $id, EntityManagerInterface $entityManager, CategorieRepository $competenceRepository): Response
	{
		$competence = $competenceRepository->find($id);

		$entityManager->remove($competence);
		$entityManager->flush();

		$this->addFlash('success', "This skill has been successfully removed");
		$this->addFlash('success', "« #" . $competence->getId() . " - " . $competence->getName() . " »");
		return $this->redirectToRoute('app_home');
	}
}

