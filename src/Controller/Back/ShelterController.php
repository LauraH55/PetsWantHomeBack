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
     * @Route("/back/shelter/{id<\d+>}", name="back_shelter_read", methods="GET")
     */
    public function read(Shelter $shelter, AnimalRepository $animalRepository): Response
    {
        /* $this->denyAccessUnlessGranted('read', $animal); */
        $animals = $animalRepository->listOrderByStatus();

        return $this->render('back/animal/shelter.html.twig', [
            'shelter' => $shelter,
        ]);
    }
}
