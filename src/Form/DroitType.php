<?php

namespace App\Form;

use App\Entity\Droit;
use App\Entity\Niveau;
use Doctrine\ORM\QueryBuilder;
use App\Repository\NiveauRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DroitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Niveau', NiveauAutocompleteField::class)
            ->add('montant', NumberType::class, [
                'label' => 'Montant : '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Droit::class,
        ]);
    }
}
