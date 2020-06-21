<?php declare(strict_types=1);

namespace App\Application\Http\Controller\API;

use App\Application\Http\Request\DTO\AccessToken\AuthorizationCodeRequest;
use App\Application\Http\Request\DTO\AccessToken\ClientCredentialsRequest;
use App\Application\Http\Request\DTO\AccessToken\PasswordRequest;
use App\Constants;
use App\Domain\Service\Manager\RefreshTokenManagerInterface;
use App\Domain\Service\Token\Factory\PayloadFactoryInterface;
use App\Domain\Service\Token\TokenFacadeInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Rest\Route("/token")
 */
class TokenController extends AbstractFOSRestController
{
    private TokenFacadeInterface $tokenFacade;
    private PayloadFactoryInterface $payloadFactory;
    private RefreshTokenManagerInterface $refreshTokenManager;

    public function __construct(
        TokenFacadeInterface $tokenFacade,
        PayloadFactoryInterface $payloadFactory,
        RefreshTokenManagerInterface $refreshTokenManager
    ) {
        $this->tokenFacade = $tokenFacade;
        $this->payloadFactory = $payloadFactory;
        $this->refreshTokenManager = $refreshTokenManager;
    }

    /**
     * @Rest\Post(
     *     name="token_authorization_code",
     *     condition="context.getParameter('grant_type') == 'authorization_code'"
     * )
     */
    public function tokenAuthorizationCode(AuthorizationCodeRequest $request): JsonResponse
    {
        $payload = $this->payloadFactory->create($request->token);

        return new JsonResponse([
            'access_token'  => $this->tokenFacade->encode($payload),
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
    public function tokenClientCredentials(ClientCredentialsRequest $request): JsonResponse
    {
        return new JsonResponse([
            'access_token'  => '123',
            'token_type'    => Constants::TOKEN_TYPE,
            'expires_in'    => 123,
            'scope'         => '123',
            'state'         => '123',
        ], 201);
    }

    /**
     * @Rest\Post(
     *     name="token_password",
     *     condition="context.getParameter('grant_type') == 'password'"
     * )
     */
    public function tokenPassword(PasswordRequest $request): JsonResponse
    {
        $payload = $this->payloadFactory->createDirect($this->getUser()->getUsername(), $request->getScopes());

        return new JsonResponse([
            "access_token"  => $this->tokenFacade->encode($payload),
            "token_type"    => Constants::TOKEN_TYPE,
            "expires_in"    => $payload->expires,
            "refresh_token" => $this->refreshTokenManager->createToken($this->getUser())->getToken(),
        ]);
    }
}
