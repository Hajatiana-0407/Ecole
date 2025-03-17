<?php

namespace App\Form;

use App\Entity\Matier;
use App\Entity\MatierNiveau;
use App\Entity\Niveau;
use App\Repository\MatierNiveauRepository;
use App\Repository\MatierRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('Matier', EntityType::class, [
                'class' => Matier::class,
                'choice_label' => 'denomination',
                'label' => 'Matière : ',
                'required' => true,
                'query_builder' => function (MatierRepository $repository) use ($options): QueryBuilder {
                    // dd( $options['matieres'][0]->getMatier()->getId()) ; 
                    $matiers_id = [];
                    for ($i = 0; $i < count($options['matieres']); $i++) {
                        if ($options['matieres'][$i]->getMatier()  != null) {
                            $matiers_id[] = $options['matieres'][$i]->getMatier()->getId();
                        }
                    }
                    $qb = $repository->createQueryBuilder('m')
                        ->orderBy('m.id', 'desc');

                    if (!empty($matiers_id)) {
                        $qb->where('m.id NOT IN (:matiers)')
                            ->setParameter('matiers', $matiers_id);
                    }
                    return $qb;
                }
            ])
            ->add('coeficient', TextType::class, [
                'label' => 'Coéficient : '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MatierNiveau::class,
            'matieres' => []
        ]);
    }
}
