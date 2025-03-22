<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\MatiereNiveau;
use App\Entity\Niveau;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoeficientEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Niveau', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'nom',
                'disabled' => true,
            ])
            ->add('Matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'denomination',
                'label' => 'Matière : ',
                'disabled' => true,
            ])
            ->add('coeficient', NumberType::class, [
                'label' => 'Coéficient : '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MatiereNiveau::class,
            'Matieres' => [] , 
            'id' => 0
        ]);
    }
}
