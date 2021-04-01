<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Entity\Shelter;
use App\Form\ShelterType;
use App\Service\UploaderHelper;
use App\Repository\AnimalRepository;
use App\Repository\ShelterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ShelterController extends AbstractController
{

    /**
     * @Route("/back/shelter/{id<\d+>}", name="back_shelter_read", methods="GET")
     */
    public function read(Shelter $shelter, User $user, AnimalRepository $animalRepository): Response
    {

        /* $this->denyAccessUnlessGranted('read', $shelter); */

        /* $this->denyAccessUnlessGranted('read', $animal); */
        $animals = $animalRepository->listOrderByStatus();

        return $this->render('back/animal/shelter.html.twig', [
            'shelter' => $shelter,
            'user' => $user
        ]);
    }

    /**
     * @Entity("shelter", expr="repository.find(shelter_id)")
     * @Route("back/shelter/{shelter_id<\d+>}/update", name="back_shelter_update", methods={"GET", "POST"})
     */
    public function update(Shelter $shelter = null, Request $request, UploaderHelper $uploaderHelper): Response
    {
        // Does the User have the right to modify the file of this shelter ?
        // 'update' = voter attributes
        // $shelter = shelter Entity
        /* $this->denyAccessUnlessGranted('update', $shelter); */ 

        $form = $this->createForm(ShelterType::class, $shelter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form->get('picture')->getData();
            

            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                $shelter->setPicture($newFilename);
            } 
    
            // We send ou update in database
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_shelter_read', ['id'=> $shelter->getId()]);
        }

        return $this->render('back/shelter/update.html.twig', [
            'form' => $form->createView(),
            'shelter' => $shelter,
        ]);
    }

    /**
     * Delete a user / shelter
     * @Route("/back/shelter/{id}/delete", name="back_user_delete", methods={"DELETE"})
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

        //!TODO => Renvoyer vers la route register du FRONT quand on saura comment faire + vérifier une fois connecté que la méthode fonctionne

        return $this->json(
            ['message' => 'L\'utilisateur a bien été supprimé'],
            Response::HTTP_OK
        );
    }
}
