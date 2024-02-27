<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Panier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse', TextType::class, [
                'label' => 'Donner votre adresse:',
                'required' => true,
            ])
            ->add('delais_Cmd', TextType::class, [
                'label' => 'Command Details:',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Adjust the data class based on your Commande entity
            'data_class' => 'App\Entity\Commande',
        ]);
    }
}