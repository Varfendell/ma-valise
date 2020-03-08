<?php

namespace App\Form\Crud;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('firstName', TextType::class)->add('lastName', TextType::class)->add('email', EmailType::class)->add('phone', TextType::class, ['required' => false,])->add('city', TextType::class, ['required' => false,]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(['data_class' => User::class,]);
	}
}
