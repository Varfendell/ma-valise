<?php

namespace App\Form\Common;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AuthenticationType
 * @package App\Form
 */
class CreateAccountType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('email', TextType::class, ['label' => false,])
			//            ->add('birthdate', DateType::class, [
			//                'label' => false,
			//                'widget' => 'single_text',
			//                'html5' => false,
			//            ])
			->add('firstName', TextType::class, ['label' => false,])->add('lastName', TextType::class, ['label' => false,])
			//            ->add('city', TextType::class, [
			//                'label' => false,
			//            ])
			//            ->add('phone', TextType::class, [
			//                'label' => false,
			//            ])
			//            ->add('picture', FileType::class, [
			//                'label' => false,
			//            ])
			->add('password', RepeatedType::class, ['type' => PasswordType::class, 'invalid_message' => 'The password fields must match.', 'options' => ['attr' => ['class' => 'password-field']], 'required' => true, 'first_options' => ['label' => false], 'second_options' => ['label' => false],]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(['data_class' => User::class,]);
	}
}