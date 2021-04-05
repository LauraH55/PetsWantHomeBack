<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Entity\Shelter;
use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{
    /**
     * @Entity("shelter", expr="repository.find(shelter_id)")
     * @Entity("user", expr="repository.find(user_id)")
     * @Route("back/shelter/{shelter_id<\d+>}/user/{user_id<\d+>}/update", name="back_user_update", methods={"GET", "POST"})
     */
    public function update(User $user = null, Shelter $shelter = null, Request $request): Response
    {
        // Does the User have the right to modify the file of this user ?
        // 'update' = voter attributes
        // $user = user Entity
        /* $this->denyAccessUnlessGranted('update', $user); */ 

        $form = $this->createForm(LoginType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            // We send ou update in database
            $this->getDoctrine()->getManager()->flush();

            //!TODO Tester la route user une fois connecté via le login FRONT
            
            return $this->redirectToRoute('back_shelter_read', ['id'=> $user->getShelter->getId()]);
        }

        return $this->render('back/user/update.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'shelter' => $shelter
        ]);
    }
}
