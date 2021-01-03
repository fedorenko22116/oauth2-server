<?php

declare(strict_types=1);

namespace App\Application\Http\Controller\API;

use App\Application\Entity\Client;
use App\Application\Http\Request\DTO\AccessToken\AuthorizationCodeRequest;
use App\Application\Http\Request\DTO\AccessToken\ClientCredentialsRequest;
use App\Application\Http\Request\DTO\AccessToken\PasswordRequest;
use App\Application\Http\Response\ErrorResponse;
use App\Application\Service\ViewModel\Token\AuthorizationCodeViewModel;
use App\Application\Service\ViewModel\Token\ClientCredentialsViewModel;
use App\Application\Service\ViewModel\Token\PasswordViewModel;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Rest\Route("/api/token")
 */
class TokenController extends AbstractFOSRestController
{
    /**
     * @Rest\Post(
     *     name="token_authorization_code",
     *     condition="context.getParameter('grant_type') == 'authorization_code'"
     * )
     */
    public function tokenAuthorizationCode(
        AuthorizationCodeRequest $request,
        AuthorizationCodeViewModel $viewModel,
        ?Client $client
    ): JsonResponse {
        if (!$client && !$request->client) {
            return new ErrorResponse(ErrorResponse::UNAUTHORIZED_CLIENT);
        }

        return new JsonResponse($viewModel->createView($request), 201);
    }

    /**
     * @Rest\Post(
     *     name="token_client_credentials",
     *     condition="context.getParameter('grant_type') == 'client_credentials'"
     * )
     */
    public function tokenClientCredentials(
        ClientCredentialsRequest $request,
        ClientCredentialsViewModel $viewModel
    ): JsonResponse {
        return new JsonResponse($viewModel->createView($request), 201);
    }

    /**
     * @Rest\Post(name="token_password", condition="context.getParameter('grant_type') == 'password'")
     */
    public function tokenPassword(PasswordRequest $request, PasswordViewModel $viewModel): JsonResponse
    {
        return new JsonResponse($viewModel->createView($request), 201);
    }
}
