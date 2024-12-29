<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création de 10 utilisateurs avec le rôle ROLE_STUDENT sans Factory
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail("student{$i}@bayalamo.com");
            $user->setRoles(['ROLE_STUDENT']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }
        // Création d'un utilisateur
        $user = new User();
        $user->setEmail('Clarissia@BayAlamo.com');
        $user->setRoles(['ROLE_TEACHER']);
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
        $user->setPassword($hashedPassword);

        $manager->persist($user);

        // Création d'un admin
        $admin = new User();
        $admin->setEmail('admin@BayAlamo.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'password');
        $admin->setPassword($hashedPassword);

        $manager->persist($admin);

        // Enregistrer les données dans la base
        $manager->flush();
    }
}
