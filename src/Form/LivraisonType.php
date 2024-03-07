<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', DateTimeType::class, [
                'label' => 'Ajouté à',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('isConfirmed', CheckboxType::class, [
                'label' => 'Confirmé',
                'required' => false,
            ])
            ->add('commande', EntityType::class, [
                'class' => Commande::class,
                'choice_label' => 'id',
                'required' => false,
            ])
            ->add('idMembre', EntityType::class, [
                'label' => 'Livreur',
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
            'data_class' => Livraison::class,
        ]);
    }
}
