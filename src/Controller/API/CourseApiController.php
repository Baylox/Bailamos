<?php

namespace App\Controller\API;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CourseApiController extends AbstractController
{
    #[Route('/api/courses', name: 'api_courses', methods: ['GET'])]
    public function getCourses(CourseRepository $courseRepository): JsonResponse
    {
        $courses = $courseRepository->findAll();
    
        $data = array_map(function ($course) {
            return [
                'id' => $course->getId(),
                'title' => $course->getTitle(),
                'time' => $course->getTime()?->format('H:i') ?? 'Non défini',
                'duration' => $course->getDuration(),
                'dance' => [
                    'name' => $course->getDance()?->getName(),
                    'image' => '/uploads/dance_types/' . $course->getDance()?->getImage(), // Utilise le chemin de l'image
                ],
                'day_of_week' => $course->getDayOfWeek(),
            ];
        }, $courses);
    
        return $this->json($data);
    }              
}


