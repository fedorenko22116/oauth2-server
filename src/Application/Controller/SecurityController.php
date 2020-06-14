<?php

namespace App\Application\Controller;

use App\Application\Request\Dto\AuthorizationRequest;
use App\Application\Request\Form\Type\Dto\RegisterUser;
use App\Application\Request\Form\Type\RegisterType;
use App\Domain\Service\Manager\AuthTokenManagerInterface;
use App\Domain\Service\Manager\UserManagerInterface;
use App\Infrastructure\Service\UrlGeneratorInterface;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractFOSRestController
{
    /**
     * @Rest\Route("/oauth2/auth", name="app_login")
     */
    public function authenticate(
        AuthorizationRequest $request,
        AuthenticationUtils $authenticationUtils,
        AuthTokenManagerInterface $authTokenManager,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        $client = $request->client;

        if ($this->getUser()) {
            $token = $authTokenManager->createToken($this->getUser(), $client, $request->redirectUri);

            return new RedirectResponse($urlGenerator->generateUrl($request->redirectUri ?: $client->getHost(), [
                'code'  => $token->getToken(),
                'state' => $request->state,
            ]));
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'redirect_uri' => $request->redirectUri,
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
        throw new Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
