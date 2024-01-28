<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Méthode de connexion
     */
    #[Route(path: '/connexion', name: 'app_security_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            // dd("Vous êtes déjà connecté.");
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        //  flash message to notify the login was successfully
        //$this->addFlash('success', "Bonjour  Vous êtes bien connecté. Bonne navigation !");

        return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername, 
                'error' => $error
            ]
        );
    }

    /**
     * Méthode de déconnexion
     */
    #[Route(path: '/deconnexion', name: 'app_security_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
