<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Repository\MatiereRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class MatiereAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Matiere::class,
            'placeholder' => 'r',
            'choice_label' => 'denomination',
            'query_builder' => function (MatiereRepository $repository): QueryBuilder {
                return $repository->createQueryBuilder('m')
                    ->orderBy('m.id', 'desc');
            }

            // choose which fields to use in the search
            // if not passed, *all* fields are used
            // 'searchable_fields' => ['name'],

            // 'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
