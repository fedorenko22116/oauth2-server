<?php

namespace App\Controller;

use App\Entity\Client;
use App\Request\Dto\AuthRequest;
use App\Request\Form\Type\Dto\RegisterUser;
use App\Request\Form\Type\RegisterType;
use App\Service\Manager\AuthTokenManagerInterface;
use App\Service\Manager\UserManagerInterface;
use App\Util\Request\Host\HostComparatorInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractFOSRestController
{
    /**
     * @Rest\Route("/oauth2/auth", name="app_login")
     * @ParamConverter("authRequest", converter="app_request")
     * @ParamConverter("client", converter="app_doctrine", options={"params" = {"id" = "client_id"}})
     */
    public function authenticate(
        AuthRequest $authRequest,
        Client $client,
        AuthenticationUtils $authenticationUtils,
        HostComparatorInterface $hostComparator,
        AuthTokenManagerInterface $authTokenManager
    ): Response {
        if (!$hostComparator->equals($authRequest->redirectUri, $client->getHost())) {
            throw new BadRequestHttpException("Invalid redirect url provided");
        }

        if ($this->getUser()) {
            $token = $authTokenManager->createToken($this->getUser(), $client, $authRequest->redirectUri)->getToken();

            return new RedirectResponse(
                "{$authRequest->redirectUri}?code={$token}" .
                ($authRequest->state ? "&state={$authRequest->state}" : '')
            );
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'redirect_uri' => $authRequest->redirectUri,
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
