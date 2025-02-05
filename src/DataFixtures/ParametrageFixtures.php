<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ParametrageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $facker = Factory::create('fr_FR');
        $niveau_tab = [] ; 
        for ($i = 0; $i < 40; $i++) {
            $niveau = new Niveau();
            $niveau->setNom($facker->words(3 , true ));
            $manager->persist($niveau);
            # code...

            $niveau_tab[] = $niveau ; 
        }

        for ($i=0; $i < 80 ; $i++) { 
            $classe = New Classe() ; 
            $classe->setDenomination( $facker->words( 1 , true ))
                    ->setNiveau( $niveau_tab[ mt_rand( 0 , count( $niveau_tab) - 1 ) ]) ; 
            $manager->persist( $classe ) ; 
        }
        $manager->flush();
    }
}
