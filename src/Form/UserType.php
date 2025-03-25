<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom :'
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom :'
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Télephone :'
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse :'
            ])
            ->add('email', EmailType::class,  [
                "label" => 'Email :'
            ])
           
            // ->add('password', RepeatedType::class, [  // Vérification des deux champs
            //     'type' => PasswordType::class,
            //     'first_options'  => ['label' => 'Mot de passe :'],
            //     'second_options' => ['label' => 'Confirmer le mot de passe :'],
            //     'invalid_message' => 'Les mots de passe ne correspondent pas.', // Message d'erreur
            // ])
            ->add('photo', FileType::class, [
                'label' => 'Photo :',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPG, PNG)',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
