<?php

namespace App\Controller\Back;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnimalController extends AbstractController
{
    /**
     * @Route("/back/animals", name="back_animal_list", methods="GET")
     */
    public function list(AnimalRepository $animalRepository): Response
    {

        $animals = $animalRepository->listOrderByStatus();

        return $this->render('back/animal/index.html.twig', [
            'animals' => $animals,
        ]);
    }

    /**
     * @Route("back/animal/create", name="back_animal_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = new Animal();

        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($animal);
            $entityManager->flush();

            return $this->redirectToRoute('back_animal_list');
        }

        // Rendu/affichage du form
        return $this->render('back/animal/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/back/animal/{id<\d+>}/update", name="back_animal_update", methods={"GET","POST"})
     */
    public function edit(Request $request, Animal $animal): Response
    {
        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_animal_list');
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
