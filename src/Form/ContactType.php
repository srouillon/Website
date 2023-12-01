<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('identity', TextType::class, [
				'attr' => [
					'class' => 'form-control',
					'placeholder' => 'Jean DUPONT'
				]
			])
			->add('email', TextType::class, [
				'attr' => [
					'class' => 'form-control',
					'placeholder' => 'email@example.com'
				]
			])
			->add('company', TextType::class, [
				'attr' => [
					'class' => 'form-control',
					'placeholder' => 'Your company'
				]
			])
			->add('object', TextType::class, [
				'attr' => [
					'class' => 'form-control',
					'placeholder' => 'The reason for your contact'
				]
			])
			->add('message', TextareaType::class, [
				'attr' => [
					'class' => 'form-control',
					'rows' => 8,
					'placeholder' => 'Your message here...'
				]
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Contact::class,
		]);
	}
}
