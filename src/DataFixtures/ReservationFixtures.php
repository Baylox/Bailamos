<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // On récupère tous les utilisateurs et les cours existants
        $users = $manager->getRepository(User::class)->findAll();
        $courses = $manager->getRepository(Course::class)->findAll();

        // On vérifie qu'il y a bien des utilisateurs et des cours disponibles
        if (empty($users) || empty($courses)) {
            throw new \RuntimeException('Il n\'y a pas de cours ou d\'utilisateurs disponibles pour créer des réservations.');
        }

        // On crée 20 réservations aléatoires
        foreach (range(1, 20) as $i) {
            $reservation = new Reservation();
            $reservation->setUser($faker->randomElement($users)) // On associe un utilisateur existant
                        ->setCourse($faker->randomElement($courses)) // On associe un cours existant
                        ->setReservedAt(new \DateTimeImmutable($faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'))) // On génère une date aléatoire
                        ->setConfirmed($faker->boolean(75)); // 75% de chances que la réservation soit confirmée

            $manager->persist($reservation);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,    // On s'assure que les utilisateurs sont chargés
            CourseFixtures::class,  // On s'assure que les cours sont chargés avant
        ];
    }
}

