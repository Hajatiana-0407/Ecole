<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ParametrageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $facker = Factory::create('fr_FR');
        for ($i = 0; $i < 40; $i++) {
            $niveau = new Niveau();
            $niveau->setNom($facker->words(3 , true ));
            $manager->persist($niveau);
            # code...
        }
        $manager->flush();
    }
}
