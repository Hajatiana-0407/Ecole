<?php

namespace App\Form;

use App\Entity\Matier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('denomination' , TextType::class , [
                'label' => 'Dénomination :' , 
                // 'attr' => [
                //     'placeholder' => 'Mathématique' , 
                // ]
            ])
            ->add('abreviation' , TextType::class , [
                'label' => 'Abréviation :' , 
                // 'attr' => [
                //     'placeholder' => 'Math' , 
                // ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matier::class,
        ]);
    }
}
