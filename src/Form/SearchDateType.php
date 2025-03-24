<?php

namespace App\Form;

use App\Entity\Search\SearchDate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('recherche' , TextType::class , [
                'attr' => [
                    'placeholder' =>'Recherche '
                ] , 
                'required' => false,
            ])
            ->add('dateDebut' , DateType::class , [
                'widget' => 'single_text',
                'required' => false,
            ]) 
            ->add('dateFin' , DateType::class , [
                'widget' => 'single_text',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchDate::class,
            'method' => 'get' , 
            'csrf_protection' => false
        ]);
    }


    public function getBlockPrefix()
    {
        return '' ; 
    }
}
