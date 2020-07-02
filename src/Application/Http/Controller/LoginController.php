<?php

namespace App\Application\Http\Controller;

use App\Application\Http\Request\DTO\AuthorizationRequest;
use App\Application\Http\Request\Form\Type\RegisterType;
use App\Application\Service\UrlGeneratorInterface;
use App\Domain\AuthToken\AuthTokenService;
use App\Domain\User\RegisterUserDTO;
use App\Domain\User\UserService;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractFOSRestController
{
    /**
     * @Rest\Route("/auth", name="app_login")
     */
    public function authenticate(
        AuthorizationRequest $request,
        AuthenticationUtils $authenticationUtils,
        AuthTokenService $authTokenManager,
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
    public function register(Request $request, UserService $userManager): Response
    {
        $registerUser = new RegisterUserDTO();
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
     *
     * @throws Exception
     */
    public function logout(): Response
    {
        throw new Exception(
            'This method can be blank - it will be intercepted by the logout key on your firewall'
        );
    }
}
