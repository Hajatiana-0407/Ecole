<?php

namespace App\Form;

use App\Entity\MatiereNiveau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatNiveauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Niveau', NiveauAutocompleteField::class , [
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MatiereNiveau::class,
        ]);
    }
}
