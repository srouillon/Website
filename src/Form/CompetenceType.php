<?php

namespace App\Form;

use App\Entity\Competence;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetenceType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
				'attr' => [
					'class' => 'form-control',
					'placeholder' => 'Exemple'
				]
			])
			->add('categorie', EntityType::class, [
				'class' => Categorie::class,
				'choice_label' => 'name',
				'attr' => [
					'class' => 'form-control',
				]
			])
			->add('width', null, [
				'attr' => [
					'class' => 'form-control',
					'min' => 25,
					'max' => 100,
					'step' => 25
				]
			])
			->add('file', FileType::class, [
				'label' => "Image",
				'mapped' => false,
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Competence::class,
		]);
	}
}
