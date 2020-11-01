<?php

declare(strict_types=1);

namespace App\Application\Http\Controller;

use App\Application\Http\Request\DTO\AuthorizationRequest;
use App\Application\Service\UrlGeneratorInterface;
use App\Application\Service\ViewModel\Authorization\AuthorizationViewModel;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractFOSRestController
{
    /**
     * @Rest\Route("/auth", name="app_login")
     */
    public function authenticate(
        AuthorizationRequest $request,
        AuthorizationViewModel $model,
        AuthenticationUtils $authenticationUtils,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        if ($this->getUser()) {
            $domain = $request->redirectUri ?: $request->client->getHost();

            return new RedirectResponse(
                $urlGenerator->generateUrl($domain, $model->createView($request)->jsonSerialize()),
            );
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'redirect_uri' => $request->redirectUri,
            'client_id' => $request->client->getId(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
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
            'This method can be blank - it will be intercepted by the logout key on your firewall',
        );
    }
}
