<?php

namespace App\Form;

use App\Entity\Search\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('recherche', TextType::class , [
                'attr' => [
                    'placeholder' => 'Recherche...'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'get' , 
            'csrf_protection' => false ,
        ]);
    }

    public function getBlockPrefix()
    {
        return '' ; 
    }
}
