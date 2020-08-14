<?php

declare(strict_types=1);

namespace App\Application\Service\ViewModel\Token;

use App\Application\Entity\User;
use App\Application\Http\Request\DTO\AccessToken\AuthorizationCodeRequest;
use App\Application\Service\ViewModel\Token\View\TokenModel;
use App\Application\Service\ViewModel\ViewInterface;
use App\Domain\AccessToken\AccessTokenService;
use App\Domain\AccessToken\Factory\PayloadFactoryInterface;
use App\Domain\RefreshToken\RefreshTokenService;

final class AuthorizationCodeViewModel
{
    private PayloadFactoryInterface $payloadFactory;
    private AccessTokenService $accessTokenService;
    private RefreshTokenService $refreshTokenManager;

    public function __construct(
        PayloadFactoryInterface $payloadFactory,
        AccessTokenService $accessTokenService,
        RefreshTokenService $refreshTokenManager
    ) {
        $this->payloadFactory = $payloadFactory;
        $this->accessTokenService = $accessTokenService;
        $this->refreshTokenManager = $refreshTokenManager;
    }

    public function createView(AuthorizationCodeRequest $request): ViewInterface
    {
        /** @var User $user */
        $user = $request->token->getUser();
        $payload = $this->payloadFactory->create($request->token);

        return new TokenModel(
            $this->accessTokenService->encode($payload),
            $payload->expires,
            $this->refreshTokenManager->createToken($user)->getToken(),
        );
    }
}
