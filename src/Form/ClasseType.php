<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Niveau;
use App\Repository\NiveauRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('niveau', EntityType::class, [
                'class' =>  Niveau::class,
                'choice_label' => 'nom',
                'query_builder' => function ( NiveauRepository $repository ) : QueryBuilder {
                    return $repository->createQueryBuilder('n')
                            ->orderBy('n.id' , 'desc') ; 
                } , 
                'label' => 'Niveau' , 
                'attr' => [
                    'class' => 'ui search dropdown'
                ]
            ])
            ->add('denomination')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}
