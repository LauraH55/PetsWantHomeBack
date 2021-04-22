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
    public function create(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, ValidatorInterface $validator)
    {

        $shelterData = $request->request->all();

        $errors = $validator->validate($shelterData);

        if (count($errors) > 0) {

            // The array of errors is returned as JSON
            // With an error status 422
            // @see https://fr.wikipedia.org/wiki/Liste_des_codes_HTTP
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $shelter = new Shelter();
        $user = $this->getUser();

        if ($user->getShelter() !== null) {
            return $this->json([
                'error' => "Vous avez déjà un refuge",
            ], Response::HTTP_BAD_REQUEST);
        }

        $shelter->setUser($user);
        $shelter->setPhoneNumber($shelterData['phone_number']);
        $shelter->setName($shelterData['name']);
        $shelter->setEmail($shelterData['email']);
        $shelter->setAddress($shelterData['address']);
        $user->setRoles(['ROLE_SHELTER']);


        // retrieves an instance of UploadedFile identified by picture
        $uploadedFile = $request->files->get('picture');

        if ($uploadedFile) {
            $newFilename = $uploaderHelper->uploadImage($uploadedFile);
            $shelter->setPicture($newFilename);
        }
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
     * @Route("/api/shelter/update", name="api_shelter_update_put", methods={"PUT"})
     * @Route("/api/shelter/update", name="api_shelter_update_patch", methods={"PATCH"})
     */
    public function shelterUpdate(EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, SerializerInterface $serializer, Request $request, ValidatorInterface $validator)
    {

        if ($this->getUser()) {

            $user = $this->getUser();
            $shelter = $user->getShelter();

            $shelterData = $request->request->all();

            $errors = $validator->validate($shelterData);

            if (count($errors) > 0) {

                // The array of errors is returned as JSON
                // With an error status 422
                // @see https://fr.wikipedia.org/wiki/Liste_des_codes_HTTP
                return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $shelter->setPhoneNumber($shelterData['phone_number']);
            $shelter->setName($shelterData['name']);
            $shelter->setEmail($shelterData['email']);
            $shelter->setAddress($shelterData['address']);

            // retrieves an instance of UploadedFile identified by picture
            $uploadedFile = $request->files->get('picture');

            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                $shelter->setPicture($newFilename);
            }
            // We save the shelter
            $entityManager->persist($shelter);
            $entityManager->flush();


            // We redirect to api_shelter_read
            return $this->json([
                'shelter' => $shelter,
            ], Response::HTTP_CREATED);
        }


        // 1. We want to modify the refuge whose id is transmitted via the URL
        // 404 page error ?
        if ($this->getUser()->getShelter() === null) {
            // We return a JSON message + a 404 status
            return $this->json(['error' => 'Désolé, ce refuge n\'existe pas.'], Response::HTTP_NOT_FOUND);
        }

    }
}
