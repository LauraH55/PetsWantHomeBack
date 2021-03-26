<?php

namespace App\Controller\Api;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * API Animals
 */
class AnimalController extends AbstractController
{
    /**
     * Read all animal List 
     * @Route("/api/animals", name="api_animal_list", methods="GET")
     */
    public function animalList(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->findAll();

        return $this->json($animals, 200, [], ['groups' => 'animal_list']);
    }

    /**
     * Animal page 
     * 
     * @Route("/api/animal/{id<\d+>}", name="api_animal_read", methods="GET")
     */
    public function animalRead(Animal $animal = null): Response
    {
        // 404 error page
        if ($animal === null) {

            // Optional, message for the front
            $message = [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Désolé cet animal n\'exsite pas.',
            ];

            // We define a custom message and an HTTP 404 status code
            return $this->json($message, Response::HTTP_NOT_FOUND);
        }

        // We return our data with a status 200, the headers and our groups
        return $this->json($animal, 200, [], ['groups' => 'animal_list']);
    }


}
