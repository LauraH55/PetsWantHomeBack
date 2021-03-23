<?php

namespace App\Controller\Api;

use App\Entity\Shelter;
use App\Repository\ShelterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API Shelter
 */
class ShelterController extends AbstractController
{
    /**
     * Read all shelter List 
     * @Route("/api/shelters", name="api_shelter_list", methods="GET")
     */
    public function shelterList(ShelterRepository $shelterRepository): Response
    {
        $shelters = $shelterRepository->findAll();

        return $this->json($shelters, 200, []);
    }

    /**
     * Shelter page
     * @Route("/api/shelter/{id<\d+>}", name="api_shelter_read", methods="GET")
     */
    public function shelterRead(Shelter $shelter = null): Response
    {
        // 404 error page
        if ($shelter === null) {

            // Optional, message for the front
            $message = [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Désolé ce refuge n\'exsite pas.',
            ];

            // We define a custom message and an HTTP 404 status code
            return $this->json($message, Response::HTTP_NOT_FOUND);
        }

        return $this->json($shelter, 200, []);
    }
}
