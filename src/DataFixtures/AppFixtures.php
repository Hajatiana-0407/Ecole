<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->passwordHasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {

        $facker = Factory::create('fr_FR');
        $user = new User();
        $user->setEmail('haja@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword($user, '123456'))
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);



        // proffesseur 
        for ($i = 0; $i < 20; $i++) {
            $professeur = new User();
            $professeur->setNom($facker->firstName)
                ->setPrenom($facker->lastName)
                ->setTelephone($facker->phoneNumber)
                ->setAdresse($facker->address)
                ->setEmail($facker->email)
                ->setPassword($this->passwordHasher->hashPassword($professeur, '123456'))
                ->setRoles(["ROLE_ADMIN"])
                ->setPhoto('')
            ;

            $manager->persist($professeur);
        }

        $manager->flush();
    }
}
