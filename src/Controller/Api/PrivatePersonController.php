<?php

namespace App\Controller\Api;

use App\Entity\PrivatePerson;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PrivatePersonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrivatePersonController extends AbstractController
{
    /**
     * Read all PrivatePerson List 
     * @Route("/api/persons", name="api_person_list", methods="GET")
     */
    public function PersonList(PrivatePersonRepository $privatePersonRepository): Response
    {
        $privatePersons = $privatePersonRepository->findAll();

        return $this->json($privatePersons, 200, [], ['groups' => 'person_list']);
    }

    /**
     * Private Person page
     * @Route("/api/person/{id<\d+>}", name="api_person_read", methods="GET")
     */
    public function PersonRead(PrivatePerson $privatePerson = null): Response
    {
        // 404 error page
        if ($privatePerson === null) {

            // Optional, message for the front
            $message = [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Désolé ce profil n\'existe pas.',
            ];

            // We define a custom message and an HTTP 404 status code
            return $this->json($message, Response::HTTP_NOT_FOUND);
        }

        return $this->json($privatePerson, 200, [], ['groups' => 'person_list']);
    }

    /**
     * Create a private person
     * We need Request and Serialize
     * @Route("/api/person/create", name="api_person_create", methods="POST")
     */
    public function create(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, ValidatorInterface $validator)
    {

        $personData = $request->request->all();

        $errors = $validator->validate($personData);

        if (count($errors) > 0) {

            // The array of errors is returned as JSON
            // With an error status 422
            // @see https://fr.wikipedia.org/wiki/Liste_des_codes_HTTP
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $person = new PrivatePerson();
        $user = $this->getUser();

        if ($user->getShelter() !== null) {
            return $this->json([
                'error' => "Vous avez déjà un refuge",
            ], Response::HTTP_BAD_REQUEST);
        }

        $person->setUser($user);
        $person->setFirstname($personData['firstname']);
        $person->setLastname($personData['lastname']);
        $user->setRoles(['ROLE_USER']);


        // retrieves an instance of UploadedFile identified by picture
        $uploadedFile = $request->files->get('picture');

        if ($uploadedFile) {
            $newFilename = $uploaderHelper->uploadImage($uploadedFile);
            $person->setPicture($newFilename);
        }
        // We save the person
        $entityManager->persist($person);
        $entityManager->flush();


        // We redirect to api_shelter_read
        return $this->json([
            'person' => $person,
        ], Response::HTTP_CREATED);
    }

    /**
     * Edit private person (PUT et PATCH)
     * 
     * @Route("/api/person/update", name="api_person_update_put", methods={"PUT"})
     * @Route("/api/person/update", name="api_person_update_patch", methods={"PATCH"})
     */
    public function personUpdate(PrivatePerson $privatePerson = null, EntityManagerInterface $entityManager, SerializerInterface $serializer, Request $request, ValidatorInterface $validator)
    {

        if ($this->getUser()->getPrivatePerson() === null) {
            return $this->json(['error' => 'Profil non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        // Notre JSON qui se trouve dans le body
        $jsonContent = $request->getContent();

        $privatePerson = $this->getUser()->getPrivatePerson();

        $serializer->deserialize(
            $jsonContent,
            PrivatePerson::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $privatePerson]
        );

        $errors = $validator->validate($privatePerson);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->flush();


        return $this->json(['message' => 'Profil modifié.'], Response::HTTP_OK);

        

    }


    /**
     * Edit Private Person Image (POST)
     * 
     * @Route("/api/person/update/image", name="api_person_update_image", methods={"POST"})
     */
    public function updatePersonImage(EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper, Request $request, ValidatorInterface $validator)
    {
        
        // We should make an edit function specially for image because in API we couldn't use the methods PUT and PATCH with the multipart/form-data
             
        $user = $this->getUser();
        
        $person = $user->getPrivatePerson();
        
        $personData = $request->request->all();
        
        $errors = $validator->validate($personData);
        
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
            $person->setPicture($newFilename);
        }
        // We save the person
        $entityManager->persist($person);
        $entityManager->flush();
    

        // We redirect to api_person_read
        return $this->json([
            'person' => $person,
        ], Response::HTTP_OK, [], ['groups' => 'person_list']);
    }
}
