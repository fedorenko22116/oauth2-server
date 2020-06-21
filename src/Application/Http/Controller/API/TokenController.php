<?php declare(strict_types=1);

namespace App\Application\Http\Controller\API;

use App\Application\Http\Request\DTO\AccessToken\AuthorizationCodeRequest;
use App\Application\Http\Request\DTO\AccessToken\ClientCredentialsRequest;
use App\Application\Http\Request\DTO\AccessToken\PasswordRequest;
use App\Application\Constants;
use App\Application\Http\Response\ErrorResponse;
use App\Domain\Entity\Client;
use App\Domain\Service\Manager\RefreshTokenManagerInterface;
use App\Domain\Service\Token\Factory\PayloadFactoryInterface;
use App\Domain\Service\Token\TokenEncrypterInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Rest\Route("/token")
 */
class TokenController extends AbstractFOSRestController
{
    private TokenEncrypterInterface $tokenEncrypter;
    private PayloadFactoryInterface $payloadFactory;
    private RefreshTokenManagerInterface $refreshTokenManager;

    public function __construct(
        TokenEncrypterInterface $tokenEncrypter,
        PayloadFactoryInterface $payloadFactory,
        RefreshTokenManagerInterface $refreshTokenManager
    ) {
        $this->tokenEncrypter = $tokenEncrypter;
        $this->payloadFactory = $payloadFactory;
        $this->refreshTokenManager = $refreshTokenManager;
    }

    /**
     * @Rest\Post(
     *     name="token_authorization_code",
     *     condition="context.getParameter('grant_type') == 'authorization_code'"
     * )
     */
    public function tokenAuthorizationCode(AuthorizationCodeRequest $request, ?Client $client): JsonResponse
    {
        if (!$client && !$request->client) {
            return new ErrorResponse(ErrorResponse::UNAUTHORIZED_CLIENT);
        }

        $payload = $this->payloadFactory->create($request->token);

        return new JsonResponse([
            'access_token'  => $this->tokenEncrypter->encode($payload),
            'token_type'    => Constants::TOKEN_TYPE,
            'expires_in'    => $payload->expires,
            'refresh_token' => $this->refreshTokenManager->createToken($request->token->getUser())->getToken(),
        ], 201);
    }

    /**
     * @Rest\Post(
     *     name="token_client_credentials",
     *     condition="context.getParameter('grant_type') == 'client_credentials'"
     * )
     */
    public function tokenClientCredentials(ClientCredentialsRequest $request, Client $client): JsonResponse
    {
        $payload = $this->payloadFactory->createDirect($client->getUser()->getUsername(), $request->getScopes());

        return new JsonResponse([
            "access_token"  => $this->tokenEncrypter->encode($payload),
            "token_type"    => Constants::TOKEN_TYPE,
            "expires_in"    => $payload->expires,
        ], 201);
    }

    /**
     * @Rest\Post(
     *     name="token_password",
     *     condition="context.getParameter('grant_type') == 'password'"
     * )
     */
    public function tokenPassword(PasswordRequest $request, Client $client): JsonResponse
    {
        $payload = $this->payloadFactory->createDirect($this->getUser()->getUsername(), $request->getScopes());

        return new JsonResponse([
            "access_token"  => $this->tokenEncrypter->encode($payload),
            "token_type"    => Constants::TOKEN_TYPE,
            "expires_in"    => $payload->expires,
            "refresh_token" => $this->refreshTokenManager->createToken($this->getUser())->getToken(),
        ], 201);
    }
}
