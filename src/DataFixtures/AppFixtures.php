<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher ; 
    public function __construct( UserPasswordHasherInterface $hasher )
    {
        $this->passwordHasher = $hasher ; 
    }
    public function load(ObjectManager $manager  ): void
    {
        $user = new User();
        $user->setEmail('haja@gmail.com')
                ->setPassword( $this->passwordHasher->hashPassword($user , '123456'))
                ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);
        $manager->flush();
    }
}
