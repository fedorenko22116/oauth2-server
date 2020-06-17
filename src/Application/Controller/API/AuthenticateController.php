<?php declare(strict_types=1);

namespace App\Application\Controller\API;

use App\Application\Request\DTO\AccessToken\AuthorizationCodeRequest;
use App\Application\Request\DTO\AccessToken\ClientCredentialsRequest;
use App\Application\Request\DTO\AccessToken\PasswordRequest;
use App\Constants;
use App\Domain\Service\Manager\RefreshTokenManagerInterface;
use App\Domain\Service\Token\Factory\PayloadFactoryInterface;
use App\Domain\Service\Token\TokenFacadeInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthenticateController extends AbstractFOSRestController
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
     * @Rest\Post("/authenticate", requirements={"grant_type":"(authorization_code|password|client_credentials)"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request): Response
    {
        switch ($request->query->get('grant_type')) {
            case 'authorization_code': return $this->forwardLocal('authenticateAuthorizationCode', $request);
            case 'client_credentials': return $this->forwardLocal('authenticateClientCredentials', $request);
            case 'password': return $this->forwardLocal('authenticatePassword', $request);
            default: throw new BadRequestHttpException();
        }
    }

    public function authenticateAuthorizationCode(AuthorizationCodeRequest $request): JsonResponse
    {
        $payload = $this->payloadFactory->create($request->token);

        return new JsonResponse([
            'access_token'  => $this->tokenFacade->encode($payload),
            'token_type'    => Constants::TOKEN_TYPE,
            'expires_in'    => $payload->expires,
            'refresh_token' => $this->refreshTokenManager->createToken($request->token->getUser())->getToken(),
        ], 201);
    }

    public function authenticateClientCredentials(ClientCredentialsRequest $request): JsonResponse
    {
        return new JsonResponse([
            'access_token'  => '123',
            'token_type'    => Constants::TOKEN_TYPE,
            'expires_in'    => 123,
            'scope'         => '123',
            'state'         => '123',
        ], 201);
    }

    public function authenticatePassword(PasswordRequest $request): JsonResponse
    {
        return new JsonResponse([
            'code'  => '123',
            'state' => '123',
        ]);
    }

    protected function forwardLocal(string $method, Request $request): Response
    {
        return $this->forward($this->createMethod($method), [], $request->query->all());
    }

    private function createMethod(string $method): string
    {
        return self::class . '::' . $method;
    }
}
