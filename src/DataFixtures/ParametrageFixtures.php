<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Droit;
use App\Entity\Frais;
use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Query\Expr\From;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ParametrageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $facker = Factory::create('fr_FR');
        /**
         * niveau
         */
        $niveau_tab = [];
        for ($i = 0; $i < 10; $i++) {
            $niveau = new Niveau();
            $niveau->setNom($facker->words(3, true));
            $manager->persist($niveau);
            # code...

            $niveau_tab[] = $niveau;
        }

        /**
         * classe
         */
        for ($i = 0; $i < 25; $i++) {
            $classe = new Classe();
            $classe->setDenomination($facker->words(1, true))
                ->setNiveau($niveau_tab[mt_rand(0, count($niveau_tab) - 1)]);
            $manager->persist($classe);
        }

        /**
         * frais
         */
        for ($i = 0; $i < 25; $i++) {
            $frais = new Frais();
            $frais->setMontant(mt_rand(1000 , 30000 ))
                ->setNiveau($niveau_tab[mt_rand(0, count($niveau_tab) - 1)]);
            $manager->persist($frais);
        }
        
        /**
         * Droit
         */
        for ($i = 0; $i < count( $niveau_tab ); $i++) {
            $droit = new Droit();
            $droit->setMontant(mt_rand(1000 , 30000 ))
                ->setNiveau($niveau_tab[$i]);
            $manager->persist($droit);
        }
        $manager->flush();
    }
}
