<?php

namespace App\Form;

use App\Entity\Niveau;
use Doctrine\ORM\QueryBuilder;
use App\Repository\NiveauRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class NiveauAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Niveau::class,
            'placeholder' => '',
            'choice_label' => 'nom',
            'query_builder' => function ( NiveauRepository $repository ) : QueryBuilder {
                    return $repository->createQueryBuilder('n')
                            ->orderBy('n.id' , 'desc') ; 
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
