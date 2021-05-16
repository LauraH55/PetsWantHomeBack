<?php

namespace App\Controller\Api;

use DateTime;
use App\Entity\Animal;
use App\Service\UploaderHelper;
use App\Repository\RaceRepository;
use App\Normalizer\EntityNormalizer;
use App\Repository\AnimalRepository;
use App\Repository\SpeciesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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
     * 
     * @Route("/api/animal/create", name="api_animal_create", methods="POST")
     */
    public function create(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, ValidatorInterface $validator, RaceRepository $raceRepository, SpeciesRepository $speciesRepository)
    {

        if ($this->getUser()->getShelter() == null && $this->getUser()->getPrivatePerson() == null) {
            return $this->json([
                'error' => "Vous n'avez pas de profil ni de refuge",
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

        if($user->getShelter() !== null){
            $shelter = $user->getShelter();
            $animal->setShelter($shelter);
        }

        if($user->getPrivatePerson() !== null){
            $privatePerson = $user->getPrivatePerson();
            $animal->setPrivatePerson($privatePerson);
        }
        
        $animal->setName($animalData['name']);
        $animal->setStatus($animalData['status']);
        $animal->setBirthdate(new \DateTime($animalData['birthdate']));
        $animal->setGender($animalData['gender']);
        $animal->setDescription($animalData['description']);
          
        $animal->setSpecies($speciesRepository->find($animalData['species_id']));   
        $animal->setRace($raceRepository->find($animalData['race_id']));

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
        ], Response::HTTP_CREATED, [], ['groups' => 'animal_list']);
    }

    /**
     * Update an Animal
     * 
     * @Route("/api/animal/{id<\d+>}/update", name="api_animal_update_put", methods={"PUT"})
     * @Route("/api/animal/{id<\d+>}/update", name="api_animal_update_patch", methods={"PATCH"})
     */
    public function update(Animal $animal = null, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {

        if ($this->getUser()->getShelter() === null && $this->getUser()->getPrivatePerson() == null) {
            return $this->json(['error' => 'Profil ou refuge non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        // Notre JSON qui se trouve dans le body
        $jsonContent = $request->getContent();
        
        $serializer->deserialize(
            $jsonContent,
            Animal::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $animal]
        );
        //dd($animal);
        $errors = $validator->validate($animal);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->flush();


        return $this->json(['message' => 'Animal modifié.'], Response::HTTP_OK, [], ['groups' => 'animal_list']);

    }

    /**
     * Edit animal Image (POST)
     * 
     * @Route("/api/animal/{id<\d+>}/update/image", name="api_animal_update_image", methods={"POST"})
     */
    public function updateAnimalImage(Animal $animal, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, Request $request, ValidatorInterface $validator)
    {
        
        // We should make an edit function specially for image because in API we couldn't use the methods PUT and PATCH with the multipart/form-data
        
        $animalData = $request->request->all();
        
        $errors = $validator->validate($animalData);
        
        if (count($errors) > 0) {

            // The array of errors is returned as JSON
            // With an error status 422
            // @see https://fr.wikipedia.org/wiki/Liste_des_codes_HTTP
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

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
        ], Response::HTTP_OK, [], ['groups' => 'animal_list']);
    }

    /**
     * Archive an Animal
     * 
     * @Route("api/animal/{id<\d+>}/archive", name="api_animal_archive", methods={"GET", "POST"})
     */
    public function archive(Animal $animal){
        
        // Here we get status of animal{id}
        $status = $animal->getStatus();
      
        // We create a condition to change the status of animal according to its original status
        if($status == 1){
            // Here to "archive" animal
            $status = $animal->setStatus(2);
            $this->getDoctrine()->getManager()->persist($status);
            $this->getDoctrine()->getManager()->flush();
        }else if($status == 2){
            // Here to "Desarchive" animal
            $status = $animal->setStatus(1);
            $this->getDoctrine()->getManager()->persist($status);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->json([
            'animal' => $animal,
        ], Response::HTTP_OK, [], ['groups' => 'animal_list']);

    }

    /**
     * @Route("/api/races", name="api_races", methods="GET")
     */
    public function races(RaceRepository $raceRepository): Response
    {
        $races = $raceRepository->findAll();
        return $this->json($races, 200, [], ['groups' => 'race_list']);
    }

}
