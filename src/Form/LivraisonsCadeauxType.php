<?php

namespace App\Form;

use App\Entity\Cadeaux;
use App\Entity\LivraisonsCadeaux;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class LivraisonsCadeauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('createdAt', DateTimeType::class, [
            'label' => 'Ajouté à',
            'widget' => 'single_text',
        ])
        ->add('isConfirmed', CheckboxType::class, [
            'label' => 'Confirmé',
            'required' => false,
        ])
            ->add('membre', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'prenom_user',
                'required' => false,
            ])
            ->add('listeCadeaux', EntityType::class, [
                'class' => Cadeaux::class,
                'choice_label' => 'id',
                'multiple' => true,
                'required' => false,
            ])
            ->add('livreur', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'prenom_user',
                'required' => false,
            ])
            ->add('Sauvegarder',SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LivraisonsCadeaux::class,
        ]);
    }
}
