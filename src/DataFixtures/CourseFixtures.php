<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\DanceType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // On récupère tous les types de danse existants
        $danceTypes = $manager->getRepository(DanceType::class)->findAll();

        // On vérifie qu'il y a bien des types de danse dans la base
        if (empty($danceTypes)) {
            throw new \RuntimeException('Assurez-vous d’avoir des types de danse dans la base avant de charger les cours.');
        }

        // On crée 10 cours de danse
        foreach (range(1, 10) as $i) {
            $course = new Course();
            $course->setTitle($faker->sentence(3)) 
                ->setDateTime($faker->dateTimeBetween('now', '+6 months')) 
                ->setDuration($faker->randomElement([60, 90, 120]))
                ->setDance($faker->randomElement($danceTypes)); // On associe un type de danse

            $manager->persist($course);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DanceTypeFixtures::class, // On s'assure que les types de danse sont chargés avant
        ];
    }
}

