<?php

namespace App\Controller\Back;

use App\Entity\Shelter;
use App\Repository\AnimalRepository;
use App\Repository\ShelterRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ShelterController extends AbstractController
{
    /**
     * @Route("/back/shelter/{id}", name="back_shelter_read", methods="GET")
     */
    public function read(ShelterRepository $shelterRepository, Shelter $shelter, AnimalRepository $animalRepository): Response
    {

        $animals = $animalRepository->listOrderByStatus();

        return $this->render('back/animal/list.html.twig', [
            'shelter' => $shelter,
        ]);
    }
}
