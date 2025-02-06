<?php

namespace App\Form;

use App\Entity\Niveau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NiveauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' , TextType::class , [
                'label' => 'Nom : '
            ]  )
            ->add('frais' , NumberType::class , [
                'mapped' => false , // le champs n\' est pas ne Niveau
                'label' => 'Frais de scolarité ' , 
                'required' => true , 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Niveau::class,
        ]);
    }
}
