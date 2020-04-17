<?php

namespace App\Form\Crud;

use App\Entity\Cagnotte;
use App\Entity\Project;
use App\Entity\User;
use App\Entity\Wishes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
            ->add('wishes', EntityType::class, [
                'expanded' => false,
                'multiple' => true,
                'class' => Wishes::class,
                'mapped' => false,
                'label' => "Quelles sont tes envies?",
                'choice_label' => 'nature',
                'attr' => ['class' => 'js-select2']
            ])->add('dateStart', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'startPicker'],
                'html5' => false,
            ])->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'endPicker'],
                'html5' => false,
            ])->add('who', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Seul(e)' => false,
                    'En couple' => false,
                    'En famille' => false,
                    'Entre amis' => false],
                'expanded' => true,
                'multiple' => false
            ])->add('description', TextareaType::class)
            ->add('cagnotte', EntityType::class, [
                'class' => Cagnotte::class,
                'choice_label' => function (Cagnotte $cagnotte) {
                    if (!empty($cagnotte->getProject())) {
                        $label = 'Cagnotte ' . $cagnotte->getId() . ' du projet ' . $cagnotte->getProject()->getName();
                    } else {
                        $label = 'Cagnotte ' . $cagnotte->getId() . ' sans projet ';
                    }
                    return $label;
                },
            ])->add('user', EntityType::class, [
                'label' => 'Utilisateur',
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getFirstNameLastName();
                }]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Project::class,]);
    }
}
