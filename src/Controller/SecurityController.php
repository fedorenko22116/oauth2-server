<?php

namespace App\Controller;

use App\Entity\Client;
use App\Request\Form\Type\Dto\RegisterUser;
use App\Request\Form\Type\RegisterType;
use App\Service\Manager\UserManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractFOSRestController
{
    /**
     * @Rest\Route("/login", name="app_login")
     */
    public function login(Client $client, AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirect('target_path');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'redirect_uri' => $client->getRedirectUrl(),
            'client_id' => $client->getId(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Rest\Get("/register")
     */
    public function register(Request $request, UserManagerInterface $userManager): Response
    {
        $registerUser = new RegisterUser();
        $form = $this->createForm(RegisterType::class, $registerUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->createUser($registerUser);
            $this->addFlash('success', 'User successfully created!');
        }

        return $this->render('simple-form.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Rest\Get("/logout", name="app_logout")
     */
    public function logout(): Response
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
