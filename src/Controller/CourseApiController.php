<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CourseApiController extends AbstractController
{
    #[Route('/api/courses', name: 'api_courses', methods: ['GET'])]
    public function getCourses(CourseRepository $courseRepository): JsonResponse
    {
        // Récupère tous les cours
        $courses = $courseRepository->findAll();

        // Formate les données pour le JSON
        $data = array_map(function ($course) {
            return [
                'id' => $course->getId(),
                'title' => $course->getTitle(),
                'time' => $course->getTime()?->format('H:i') ?? 'Non défini', // Gestion null
                'duration' => $course->getDuration(),
                'dance' => (string) $course->getDance(),
                'day_of_week' => $course->getDayOfWeek(),
            ];
        }, $courses);

        // Retourne les données sous forme de JSON
        return $this->json($data);
    }
}


