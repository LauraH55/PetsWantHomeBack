<?php

namespace App\Controller\Api;

use DateTime;
use App\Entity\Race;
use App\Entity\Animal;
use App\Entity\Species;
use App\Service\UploaderHelper;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * API Animals
 */
class AnimalController extends AbstractController
{

    /**
     * @Route("/api/home", name="api_home", methods="GET")
     */
    public function home(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->randomAnimals();

        return $this->json($animals, 200, [], ['groups' => 'animal_list']);
    }

    /**
     * Read all animal List 
     * @Route("/api/animals", name="api_animal_list", methods="GET")
     */
    public function animalList(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->listOrderByCreationDate();

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

    /**
     * Create Animal
     * We need Request and Serialize
     * @Route("/api/animal/create", name="api_animal_create", methods="POST")
     */
    public function create(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, ValidatorInterface $validator)
    {

        if ($this->getUser()->getShelter() == null) {
            return $this->json([
                'error' => "Vous n'avez pas de refuge",
            ], Response::HTTP_BAD_REQUEST);
        }

        $animalData = $request->request->all();

        $errors = $validator->validate($animalData);

        if (count($errors) > 0) {

            // The array of errors is returned as JSON
            // With an error status 422
            // @see https://fr.wikipedia.org/wiki/Liste_des_codes_HTTP
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $animal = new Animal();
        $user = $this->getUser();
        $shelter = $user->getShelter();
        
        $animal->setShelter($shelter);
        $animal->setName($animalData['name']);
        $animal->setStatus($animalData['status']);
        $animal->setBirthdate(new \DateTime($animalData['birthdate']));
        $animal->setGender($animalData['gender']);
        $animal->setDescription($animalData['description']);
        $animal->setSpecies(new Species($animalData['species_id']));      
        $animal->setRace(new Race($animalData['race_id']));
        $animal->setCatCohabitation($animalData['cat_cohabitation']);
        $animal->setDogCohabitation($animalData['dog_cohabitation']);
        $animal->setNacCohabitation($animalData['nac_cohabitation']);
        $animal->setChildCohabitation($animalData['child_cohabitation']);
        $animal->setUnknownCohabitation($animalData['unknown_cohabitation']);
        
        // retrieves an instance of UploadedFile identified by picture
        $uploadedFile = $request->files->get('picture');

        if ($uploadedFile) {
            $newFilename = $uploaderHelper->uploadImage($uploadedFile);
            $animal->setPicture($newFilename);
        }
        // We save the animal
        $entityManager->persist($animal);
        $entityManager->flush();


        // We redirect to api_animal_read
        return $this->json([
            'animal' => $animal,
        ], Response::HTTP_CREATED);
    }

}
