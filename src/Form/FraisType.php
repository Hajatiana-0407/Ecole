<?php

namespace App\Form;

use App\Entity\Frais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FraisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Niveau', NiveauAutocompleteField::class )
            ->add('montant' , NumberType::class , [
                'attr' => [
                    'min' => 100 
                ] , 
                'label' => 'Frais de scolarité :'
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Frais::class,
        ]);
    }
}
