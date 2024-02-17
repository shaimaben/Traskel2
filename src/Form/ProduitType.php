<?php

namespace App\Form;

use App\Entity\CategorieProd;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomProd')
            ->add('descrpProd')
            ->add('photoProd')
            ->add('typeProd')
            ->add('prixProd')
            ->add('idUser', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
            ->add('idCat', EntityType::class, [
                'class' => CategorieProd::class,
'choice_label' => 'id',
            ])
            ->add('panier', EntityType::class, [
                'class' => Panier::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
