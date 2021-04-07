<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Shelter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class SecurityController extends AbstractController
{
     /**
     * @Entity("shelter", expr="repository.find(shelter_id)")
     * @Route("/login", name="app_login", methods={"GET","POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils, User $user = null): Response
    {
    
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->getUser()) {    

            $user = $this->getUser();
            return $this->redirectToRoute('back_shelter_read', ['shelter_id'=> $user->getShelter()->getId()]);
        }

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        
        
    }

    /**
     * This method will be called if the authentication is valid
     * and that the user has been logged in by the security system
     * 
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    /* public function apiLogin(Shelter $shelter)
    {   
        // At this stage, the user is considered to be connected to the system
        // We will return to the front, what we want
        // To be adapted according to our needs
        $user = $this->getUser();
        $shelter = $user->getShelter()->getId();
        

        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'shelter' => $shelter
        ]);
    } */
}
