<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('username', TextType::class, [
				'attr' => [
					'class' => 'form-control'
				]
			])
			->add('newPassword', RepeatedType::class, [
				'type' => PasswordType::class,
				'invalid_message' => 'Les deux mots de passe doivent être identiques',
				'options' => ['attr' => ['class' => 'password-field form-control']],
				'required' => false,
				'mapped' => false,
				'first_options'  => ['label' => 'Password'],
				'second_options' => ['label' => 'Confirm your password'],
				'constraints' => [
					new Length([
						'min' => 6,
						'minMessage' => 'Your password should be at least {{ limit }} characters',
						// max length allowed by Symfony for security reasons
						'max' => 4096,
					])
				]
			])
			->add('email', EmailType::class, [
				'attr' => [
					'class' => 'form-control'
				]
			])
			->add('description_en', TextareaType::class, [
				'attr' => [
					'rows' => 5,
					'class' => 'form-control'
				]
			])
			->add('description_fr', TextareaType::class, [
				'attr' => [
					'rows' => 5,
					'class' => 'form-control'
				]
			])
			->add('file', FileType::class, [
				'label' => "Image",
				'mapped' => false,
				'required' => false,
				'attr' => [
					'class' => 'form-control'
				]
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => User::class,
		]);
	}
}

