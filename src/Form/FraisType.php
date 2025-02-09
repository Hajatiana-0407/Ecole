<?php

namespace App\Form;

use App\Entity\Frais;
use App\Entity\Niveau;
use App\Repository\NiveauRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FraisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Niveau', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'nom',
                'query_builder' => function (NiveauRepository $repository): QueryBuilder {
                    return $repository->createQueryBuilder('n')
                        ->orderBy('n.id', 'desc')
                    ;
                },
                'attr' => [
                    'class' => 'ui search dropdown'
                ] , 
                'label' => 'Niveau :'
            ])
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
