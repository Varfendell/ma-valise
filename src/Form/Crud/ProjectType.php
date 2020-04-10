<?php

namespace App\Form\Crud;

use App\Entity\Cagnotte;
use App\Entity\Project;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', TextType::class, ['label' => 'Quel est le nom de ton projet?'])->add('desires', ChoiceType::class, ['label' => 'Quelles sont tes envies?', 'required' => false, 'choices' => ['#Aventure' => false, '#Rando' => false], 'expanded' => true, 'multiple' => true])->add('dateStart', DateType::class, ['label' => 'Quand souhaites-tu partir?'])->add('dateEnd', DateType::class, ['label' => 'Quand souhaites-tu revenir?'])->add('description', TextType::class, ['label' => 'Quelle est ton idée de projet?'])->add('cagnotte', EntityType::class, ['label' => 'Avec quelle cagnotte?', 'class' => Cagnotte::class, 'choice_label' => function (Cagnotte $cagnotte) {
			if (!empty($cagnotte->getProject())) {
				$label = 'Cagnotte ' . $cagnotte->getId() . ' du projet ' . $cagnotte->getProject()->getName();
			}
			else {
				$label = 'Cagnotte ' . $cagnotte->getId() . ' sans projet ';
			}
			return $label;
		},])->add('user', EntityType::class, ['label' => 'Utilisateur', 'class' => User::class, 'choice_label' => function (User $user) {
			return $user->getFirstNameLastName();
		},],);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(['data_class' => Project::class,]);
	}
}
