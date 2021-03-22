<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login")
     */
    public function login(): Response
    {
        $shelter = $this->getUser();

        return $this->json([
            'email' => $shelter->getEmail(),
            //'roles' => $shelter->getRoles(),
        ]);
    }
}
