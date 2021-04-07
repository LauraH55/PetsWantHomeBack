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
use Symfony\Component\HttpFoundation\RedirectResponse;

class ShelterController extends AbstractController
{

    /**
     * @Route("/back/mainsite", name="back_mainsite", methods="GET")
     */
    public function backToMainsite(){

        return $this->redirect('http://petswanthome.surge.sh');
    }

    /**
     * @Route("/back/myshelter", name="back_shelter_read", methods="GET")
     */
    public function read(Request $request): Response
    {
        if($this->getUser()){
            $user = $this->getUser();
            $shelter = $user->getShelter();

            return $this->render('back/animal/shelter.html.twig', [
                'shelter' => $shelter,
                'user' => $user
            ]);
            
        }
        
        return $this->redirectToRoute('app_login');
        
    }

    /**
     * @Route("back/shelter/update", name="back_shelter_update", methods={"GET", "POST"})
     */
    public function update(Request $request, UploaderHelper $uploaderHelper): Response
    {
       
        $user = $this->getUser();
        $shelter = $user->getShelter();

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

            return $this->redirectToRoute('back_shelter_read');
        }

        return $this->render('back/shelter/update.html.twig', [
            'form' => $form->createView(),
            'shelter' => $shelter,
        ]);
    }

    /**
     * Delete a user / shelter
     * @Route("/back/shelter/{id<\d+>}/delete", name="back_shelter_delete", methods={"DELETE"})
     */
    public function delete(Shelter $shelter, Request $request, EntityManagerInterface $entityManager): Response
    {
    
        $em = $this->getDoctrine()->getManager();

        if(!$shelter)
        {
            throw $this->createNotFoundException('No ID found');
        }

       $submittedToken = $request->request->get('token');

        // 'delete-movie' is the same value used in the template to generate the token
        if (! $this->isCsrfTokenValid('delete-shelter', $submittedToken)) {
            // On jette une 403
            throw $this->createAccessDeniedException('Are you token to me !??!??');
        }


        $em->remove($shelter);
        $em->flush();

        return $this->redirect('http://petswanthome.surge.sh');

    }
}
