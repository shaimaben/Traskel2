<?php

namespace App\Form;

use App\Entity\CategorieProd;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomProd')
            ->add('descrpProd')
            ->add('photoProd', FileType::class, [
                'label' => 'Télécharger une photo',
                'mapped' => false, // This is important to prevent saving the file path to the database
                'required' => false, // Not required since it's an upload
            ])
            ->add('typeProd', ChoiceType::class, [
                'choices' => [
                    'Don' => 'don',
                    'Vente' => 'vente',
                ],
                'label' => 'Type de produit',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('prixProd')
            ->add('idCat', EntityType::class, [
                'class' => CategorieProd::class,
                'choice_label' => 'CategorieProd', 
            ])
            
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}