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
     * @Route("/api/user", name="api_user")
     */
    public function index(): Response
    {
        return $this->render('api/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * Edit user (PUT et PATCH)
     * 
     * @Route("/api/user/{id<\d+>}/update", name="api_user_update_put", methods={"PUT"})
     * @Route("/api/user/{id<\d+>}/update", name="api_user_update_patch", methods={"PATCH"})
     */
    public function userUpdate(User $user = null, EntityManagerInterface $em, SerializerInterface $serializer, Request $request, ValidatorInterface $validator, $data)
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
}
