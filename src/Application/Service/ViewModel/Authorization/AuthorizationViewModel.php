<?php

declare(strict_types=1);

namespace App\Application\Service\ViewModel\Authorization;

use App\Application\Entity\Scope;
use App\Application\Entity\User;
use App\Application\Http\Request\DTO\AuthorizationRequest;
use App\Application\Service\ViewModel\Authorization\View\CodeView;
use App\Application\Service\ViewModel\Authorization\View\TokenView;
use App\Application\Service\ViewModel\ViewInterface;
use App\Domain\AccessToken\AccessTokenService;
use App\Domain\AccessToken\Factory\PayloadFactoryInterface;
use App\Domain\AuthToken\AuthTokenService;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Webmozart\Assert\Assert;

final class AuthorizationViewModel
{
    private AuthTokenService $authTokenService;
    private PayloadFactoryInterface $payloadFactory;
    private AccessTokenService $accessTokenService;
    private TokenStorageInterface $tokenStorage;

    public function __construct(
        AuthTokenService $authTokenService,
        PayloadFactoryInterface $payloadFactory,
        AccessTokenService $accessTokenService,
        TokenStorageInterface $tokenStorage
    ) {
        $this->authTokenService = $authTokenService;
        $this->payloadFactory = $payloadFactory;
        $this->accessTokenService = $accessTokenService;
        $this->tokenStorage = $tokenStorage;
    }

    public function createView(AuthorizationRequest $request): ViewInterface
    {
        /** @var TokenInterface $token */
        $token = $this->tokenStorage->getToken();

        Assert::notNull($token);

        /** @var User $user */
        $user = $token->getUser();

        switch ($request->responseType) {
            case AuthorizationRequest::RESPONSE_TYPE_CODE:
                $token = $this->authTokenService
                    ->createToken($user, $request->client, $request->redirectUri);

                return new CodeView($token->getToken(), $request->state);
            case AuthorizationRequest::RESPONSE_TYPE_TOKEN:
                $payload = $this->payloadFactory->createDirect(
                    $token->getUsername(),
                    $request->client->getScopes()->map(fn(Scope $scope) => $scope->getName()),
                );

                return new TokenView(
                    $this->accessTokenService->encode($payload),
                    $request->state,
                    $payload->expires,
                );
        }

        throw new UnprocessableEntityHttpException();
    }
}
