<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\CompetenceRepository;
use App\Repository\ExperienceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
	#[Route('/', name: 'app_home')]
	public function index(CategorieRepository $competenceCategorieRepository, UserRepository $userRepository, ExperienceRepository $experienceRepository): Response
	{
		return $this->render('app/index.html.twig', [
			'categories' => $competenceCategorieRepository->findAll(),
			'experiences' => $experienceRepository->findAll(),
			'user' => $userRepository->find(1),
		]);
	}
}