<?php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;





class UserController extends AbstractController
{
    /**
     * @Route("/api/register", name="api_register", methods={"POST"})
     */
    public function register(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, Request $request, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $jsonContent = $request->getContent();
        
        $user = $serializer->deserialize($jsonContent, User::class, 'json');

        $errors = $validator->validate($user);

        if (count($errors) > 0) {

            // The array of errors is returned as JSON
            // With an error status 422
            // @see https://fr.wikipedia.org/wiki/Liste_des_codes_HTTP
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        // This is where we encode the User password (found in $ user)
        $hashedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
        // We reassign the password encoded in the User
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_SHELTER']);
        // We save the user (if submitted is valid ...)
        // We save the user
        $entityManager->persist($user);
        $entityManager->flush();
          
        return $this->json([
                'user' => $user
            ], Response::HTTP_CREATED);
    }


    /**
     * Edit user (PUT et PATCH)
     *
     * @Route("/api/user/{id<\d+>}/update", name="api_user_update_put", methods={"PUT"})
     * @Route("/api/user/{id<\d+>}/update", name="api_user_update_patch", methods={"PATCH"})
     */
    public function update(User $user = null, EntityManagerInterface $em, SerializerInterface $serializer, Request $request, ValidatorInterface $validator, $data)
    {
        // 1. We want to modify the refuge whose id is transmitted via the URL
        // 404 page error ?
        if ($user === null) {
            // We return a JSON message + a 404 status
            return $this->json(['error' => 'Désolé cet utilisateur n\'existe pas.'], Response::HTTP_NOT_FOUND);
        }

        // Our JSON which is in the body
        $jsonContent = $request->getContent();

        $serializer->deserialize(
            $jsonContent,
            User::class,
            'json',
            // We have this additional argument which tells the serializer which existing entity to modify
            [AbstractNormalizer::OBJECT_TO_POPULATE => $user]
        );

        // Validate the deserialize entity
        $errors = $validator->validate($user);
        // Generate errors
        if (count($errors) > 0) {
            // We return the error table in Json to the front with a status code 422
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // On flush $user which has been modified by the Serializer
        $em->flush();

        return $this->json(['message' => 'Informations de connexion modifiées.'], Response::HTTP_OK);
    }

    /**
     * Delete a user / shelter
     * 
     * @Route("/api/user/{id}/delete", name="api_user_delete", methods={"DELETE"})
     */
    public function delete(User $user = null, EntityManagerInterface $entityManager): Response
    {
    
        if ($user === null) {

            // Optional, message for the front
            $message = [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Utilisateur non trouvé.',
            ];
            // We define a custom message and an HTTP 404 status code
            return $this->json($message, Response::HTTP_NOT_FOUND);
        }
        
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->json(
            ['message' => 'L\'utilisateur a bien été supprimé'],
            Response::HTTP_OK
        );
    }
}