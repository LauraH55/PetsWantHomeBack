<?php

namespace App\Controller\Back;

use App\Entity\Animal;
use App\Entity\Shelter;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use App\Repository\ShelterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnimalController extends AbstractController
{

    /**
     * @Route("back/animal/create", name="back_animal_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Instance of our Object
        $animal = new Animal();

        // We create a form
        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // If the form is send and valid, we save our data and send in the database
            $animal->setShelter($this->getUser());

            $entityManager->persist($animal);
        
            $entityManager->flush();


            return $this->redirectToRoute('back_shelter_read', ['id' => $animal->getShelter()->getId()]);
        }

        return $this->render('back/animal/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/back/animal/{id<\d+>}/update", name="back_animal_update", methods={"GET","POST"})
     */
    public function update(Request $request, Animal $animal): Response
    {
        // Does the User have the right to modify the file of this animal ?
        // 'update' = voter attributes
        // $animal = Animal Entity
        $this->denyAccessUnlessGranted('update', $animal);

        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // We send ou update in database
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_shelter_read');
        }

        return $this->render('back/animal/update.html.twig', [
            'animal' => $animal,
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/animal/{id<\d+>}/archive", name="back_animal_archive", methods={"GET", "POST"})
     */
    public function archive(Animal $animal = null)
    {
        // Does the User have the right to archive this animal's file ?
        // 'archive' = voter attributes
        // $animal = Animal Entity
        $this->denyAccessUnlessGranted('archive', $animal);

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

        return $this->redirectToRoute('back_animal_list');

    }
}
