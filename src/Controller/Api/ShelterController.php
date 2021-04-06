<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Shelter;
use App\Service\UploaderHelper;
use App\Repository\ShelterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ParameterBag;

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

        return $this->json($shelters, 200, [], ['groups' => 'shelter_list']);
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
                'error' => 'Désolé ce refuge n\'existe pas.',
            ];

            // We define a custom message and an HTTP 404 status code
            return $this->json($message, Response::HTTP_NOT_FOUND);
        }

        return $this->json($shelter, 200, [], ['groups' => 'shelter_list']);
    }

    /**
     * Create shelter
     * We need Request and Serialize
     * @Route("/api/shelter/create", name="api_shelter_create", methods="POST")
     */
    public function create(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper)
    {

        $shelter = new Shelter;
        $user = $this->getUser();

        // retrieves an instance of UploadedFile identified by picture
        $uploadedFile = $request->files->get('picture');

        
        if ($uploadedFile) {
            $newFilename = $uploaderHelper->uploadImage($uploadedFile);
            $shelter->setPicture($newFilename);

        }

        $shelter->setUser($user);
        // We save the shelter (if submitted is valid ...)
        // We save the shelter
        $entityManager->persist($shelter);
        $entityManager->flush();

        // We redirect to api_shelter_read
        return $this->json([
            'shelter' => $shelter,
        ], Response::HTTP_CREATED);

    }

    /**
     * Edit shelter (PUT et PATCH)
     * 
     * @Route("/api/shelter/{id<\d+>}/update", name="api_shelter_update_put", methods={"PUT"})
     * @Route("/api/shelter/{id<\d+>}/update", name="api_shelter_update_patch", methods={"PATCH"})
     */
    public function shelterUpdate(Shelter $shelter = null, EntityManagerInterface $em, SerializerInterface $serializer, Request $request, ValidatorInterface $validator)
    {
        // 1. We want to modify the refuge whose id is transmitted via the URL
        // 404 page error ?
        if ($shelter === null) {
            // We return a JSON message + a 404 status
            return $this->json(['error' => 'Désolé ce refuge n\'existe pas.'], Response::HTTP_NOT_FOUND);
        }

        // Our JSON which is in the body
        $jsonContent = $request->getContent();

        $serializer->deserialize(
            $jsonContent,
            Shelter::class,
            'json',
            // We have this additional argument which tells the serializer which existing entity to modify
            [AbstractNormalizer::OBJECT_TO_POPULATE => $shelter]
        );

        // Validate the deserialize entity
        $errors = $validator->validate($shelter);
        // Generate errors
        if (count($errors) > 0) {
            // We return the error table in Json to the front with a status code 422
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // On flush $shelter which has been modified by the Serializer
        $em->flush();

        return $this->json(['message' => 'Refuge modifié.'], Response::HTTP_OK);
        
    }
}
