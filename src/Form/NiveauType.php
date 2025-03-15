<?php

namespace App\Form;

use App\Entity\Niveau;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NiveauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom : '
            ])
            ->add('frais', NumberType::class, [
                'mapped' => false, // le champs n\' est pas de Niveau
                'label' => 'Frais de scolarité :',
                'required' => true,
            ])
            ->add('droit', NumberType::class, [
                'mapped' => false, // le champs n\' est pas de Niveau
                'label' => 'Droit d\'inscription :',
                'required' => true,
                'attr' => [
                    'min' => '0',
                ],
            ])
            ->add('nbr_classe', NumberType::class, [
                'mapped' => false, // le champs n\' est pas ne Niveau
                'label' => '',
                'attr' => [
                    'min' => '0',
                    'max' => '30',
                ],
                'label' => 'Nombre de classe :',
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'mapped' => false,
                'label' => 'Niminalisation en alphabet( Classe A ) ou en chiffre ( Classe B )',
                'choices' => [
                    'Alphabet' => 'A',
                    'Chiffre' => '1'
                ],
                'expanded' => true,  // Transforme en boutons radio
                'multiple' => false, // Un seul choix possible
                'required' => false,
                'placeholder' => 'Automatique'
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
