<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\MatiereNiveau;
use App\Entity\Niveau;
use App\Repository\MatiereNiveauRepository;
use App\Repository\MatiereRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatNiveauTypeAdd extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Niveau', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'nom',
                'query_builder' => function (NiveauRepository $repository): QueryBuilder {
                    return $repository->createQueryBuilder('n')
                        ->orderBy('n.id', 'desc');
                },
                'disabled' => true,
            ])
            ->add('Matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'denomination',
                'label' => 'Matière : ',
                'required' => true,
                'query_builder' => function (MatiereRepository $repository) use ($options): QueryBuilder {
                    // dd( $options['Matieres'][0]->getMatiere()->getId()) ; 
                    $Matieres_id = [];
                    for ($i = 0; $i < count($options['Matieres']); $i++) {
                        if ($options['Matieres'][$i]->getMatiere()  != null) {
                            $Matieres_id[] = $options['Matieres'][$i]->getMatiere()->getId();
                        }
                    }
                    $qb = $repository->createQueryBuilder('m')
                        ->orderBy('m.id', 'desc');

                    if (!empty($Matieres_id)) {
                        $qb->where('m.id NOT IN (:Matieres)')
                            ->setParameter('Matieres', $Matieres_id);
                    }
                    return $qb;
                }
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
            'Matieres' => []
        ]);
    }
}
