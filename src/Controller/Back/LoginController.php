<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Entity\Shelter;
use App\Form\LoginType;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    /**
     * @Route("back/user/update", name="back_user_update", methods={"GET", "POST"})
     */
    public function update(User $user = null, Shelter $shelter = null, Request $request, UserPasswordEncoderInterface $passwordEncoder, LoggerInterface $logger): Response
    {
        $user = $this->getUser();
        $shelter = $user->getShelter();

        $form = $this->createForm(LoginType::class, $user);

        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
    
            if ($form->get('password')->getData() !== '') {
                // C'est là qu'on encode le mot de passe du User (qui se trouve dans $user)
                $hashedPassword = $passwordEncoder->encodePassword($user, $form->get('password')->getData());
                // On réassigne le mot passe encodé dans le User
                $user->setPassword($hashedPassword);
            }
            // We send ou update in database
            $this->getDoctrine()->getManager()->flush();
           
            //!TODO Tester la route user une fois connecté via le login FRONT
            $user = $this->getUser();
            
            $logger->info('identifiants modifiés', [
                'user' => $user->getUsername(),
                'by' => $this->getUser()->getUsername(),
            ]);
            
            return $this->redirectToRoute('back_shelter_read', ['shelter_id'=> $this->getUser()->getShelter()->getId()]);
        }

        return $this->render('back/user/update.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'shelter' => $shelter
        ]);
    }
}
