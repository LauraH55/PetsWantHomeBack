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
     * @Entity("shelter", expr="repository.find(shelter_id)")
     * @Route("back/shelter/{shelter_id<\d+>}/animal/create", name="back_animal_create", methods={"GET", "POST"})
     */
    public function create(Shelter $shelter, Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper): Response
    {

        // Instance of our Object
        $animal = new Animal();

        /* $this->denyAccessUnlessGranted('create', $animal); */

        $id= $request->request->get('id'); 
         

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
           /*  dd($animal); */
            // If the form is send and valid, we save our data and send in the database
            $entityManager->persist($animal);
            $entityManager->flush();


            return $this->redirectToRoute('back_shelter_read', ['shelter_id'=> $animal->getShelter()->getId()]);
        }

        return $this->render('back/animal/create.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'shelter' => $shelter,
        ]);
    }

    /**
     * @Entity("shelter", expr="repository.find(shelter_id)")
     * @Entity("animal", expr="repository.find(animal_id)")
     * @Route("back/shelter/{shelter_id<\d+>}/animal/{animal_id<\d+>}/update", name="back_animal_update", methods={"GET", "POST"})
     */
    public function update(Shelter $shelter, Animal $animal, Request $request, UploaderHelper $uploaderHelper): Response
    {
        // Does the User have the right to modify the file of this animal ?
        // 'update' = voter attributes
        // $animal = Animal Entity
        /* $this->denyAccessUnlessGranted('update', $animal); */ 

        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $animal = $form->getData();

            $uploadedFile = $form->get('picture')->getData();
            

            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                $animal->setPicture($newFilename);
            }   
    
            // We send ou update in database
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_shelter_read', ['shelter_id'=> $animal->getShelter()->getId()]);
        }

        return $this->render('back/animal/update.html.twig', [
            'form' => $form->createView(),
            'animal' => $animal,
            'shelter' => $shelter,
            
        ]);
    }

    /**
     * @Entity("shelter", expr="repository.find(shelter_id)")
     * @Entity("animal", expr="repository.find(animal_id)")
     * @Route("/animal/{animal_id<\d+>}/archive", name="back_animal_archive", methods={"GET", "POST"})
     */
    public function archive(Animal $animal = null)
    {
        // Does the User have the right to archive this animal's file ?
        // 'archive' = voter attributes
        // $animal = Animal Entity
        /* $this->denyAccessUnlessGranted('archive', $animal); */ 

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

        return $this->redirectToRoute('back_shelter_read', ['shelter_id'=> $animal->getShelter()->getId()]);

    }
}
