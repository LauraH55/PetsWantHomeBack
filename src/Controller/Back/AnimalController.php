<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Entity\Animal;
use App\Entity\Shelter;
use App\Form\AnimalType;
use App\Service\UploaderHelper;
use App\Repository\AnimalRepository;
use App\Repository\ShelterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class AnimalController extends AbstractController
{

    /**
     * @Route("back/animal/create", name="back_animal_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper): Response
    {
        $shelter = $this->getUser()->getShelter();
        // Instance of our Object
        $animal = new Animal();


        $id = $request->request->get('id'); 
         

        // We create a form
        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $animal = $form->getData();

            $uploadedFile = $form->get('picture')->getData();
            

            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                $animal->setPicture($newFilename);
            } 
           
            $animal->setShelter($shelter);
            // If the form is send and valid, we save our data and send in the database
            $entityManager->persist($animal);
            $entityManager->flush();


            return $this->redirectToRoute('back_shelter_read', ['id'=> $animal->getShelter()->getId()]);
        }

        return $this->render('back/animal/create.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'shelter' => $shelter,
        ]);
    }

    /**
     * @Route("back/animal/{id<\d+>}/update", name="back_animal_update", methods={"GET", "POST"})
     */
    public function update(Animal $animal, Request $request, UploaderHelper $uploaderHelper): Response
    {
        // Does the User have the right to modify the file of this animal ?
        // 'update' = voter attributes
        // $animal = Animal Entity
        $shelter = $this->getUser()->getShelter();

        $this->denyAccessUnlessGranted('animal_shelter', $animal);

        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form->get('picture')->getData();

            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                $animal->setPicture($newFilename);
            }   
    
            // We send ou update in database
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_shelter_read');
        }

        return $this->render('back/animal/update.html.twig', [
            'form' => $form->createView(),
            'animal' => $animal,
            'shelter' => $shelter,
            
        ]);
    }

    /**
     * @Route("back/animal/{id<\d+>}/archive", name="back_animal_archive", methods={"GET", "POST"})
     */
    public function archive(Animal $animal = null)
    {
        // Does the User have the right to archive this animal's file ?
        // 'animal_shelter' = voter attributes
        // $animal = Animal Entity
        $this->denyAccessUnlessGranted('animal_shelter', $animal);

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

        return $this->redirectToRoute('back_shelter_read');

    }
}
