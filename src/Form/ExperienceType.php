<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExperienceType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', null, [
				'attr' => [
					'class' => 'form-control',
				]
			])
			->add('enterprise', TextType::class, [
				'attr' => [
					'class' => 'form-control',
				]
			])
			->add('descriptionFr', TextareaType::class, [
				'attr' => [
					'class' => 'form-control',
					'rows' => 5
				]
			])
			->add('descriptionEn', TextareaType::class, [
				'attr' => [
					'class' => 'form-control',
					'rows' => 5
				]
			])
			->add('start', DateType::class, [
				'attr' => [
					'class' => 'form-control',
				]
			])
			->add('end', DateType::class, [
				'attr' => [
					'class' => 'form-control',
				]
			])
			->add('file', FileType::class, [
				'label' => "Image",
				'mapped' => false,
				'required' => false,
			])
			->add('keywords', TextType::class, [
				'attr' => [
					'class' => 'form-control',
				]
			])
			->add('url', TextType::class, [
				'attr' => [
					'class' => 'form-control',
				]
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Experience::class,
		]);
	}
}
