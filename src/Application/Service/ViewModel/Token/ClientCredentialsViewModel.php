<?php

declare(strict_types=1);

namespace App\Application\Service\ViewModel\Token;

use App\Application\Http\Request\DTO\AccessToken\ClientCredentialsRequest;
use App\Application\Service\ViewModel\Token\View\ClientCredentialsModel;
use App\Application\Service\ViewModel\ViewInterface;
use App\Application\Service\ViewModel\ViewModelInterface;
use App\Domain\AccessToken\AccessTokenService;
use App\Domain\AccessToken\Factory\PayloadFactoryInterface;
use App\Domain\RefreshToken\RefreshTokenService;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Webmozart\Assert\Assert;

final class ClientCredentialsViewModel implements ViewModelInterface
{
    private PayloadFactoryInterface $payloadFactory;
    private AccessTokenService $tokenEncrypter;
    private RefreshTokenService $refreshTokenManager;
    private TokenStorageInterface $tokenStorage;

    public function __construct(
        PayloadFactoryInterface $payloadFactory,
        AccessTokenService $tokenEncrypter,
        RefreshTokenService $refreshTokenManager,
        TokenStorageInterface $tokenStorage
    ) {
        $this->payloadFactory = $payloadFactory;
        $this->tokenEncrypter = $tokenEncrypter;
        $this->refreshTokenManager = $refreshTokenManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param ClientCredentialsRequest $request
     */
    public function createView(AbstractRequest $request): ViewInterface
    {
        Assert::subclassOf($request, ClientCredentialsRequest::class);

        /** @var TokenInterface $token */
        $token = $this->tokenStorage->getToken();

        Assert::notNull($token, 'User must be provided');

        /** @var UserInterface $user */
        $user = $token->getUser();
        $payload = $this->payloadFactory->createDirect($user->getUsername(), $request->getScopes());

        return new ClientCredentialsModel($this->tokenEncrypter->encode($payload), $payload->expires);
    }
}
