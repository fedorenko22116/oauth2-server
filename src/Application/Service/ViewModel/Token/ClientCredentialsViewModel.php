<?php

declare(strict_types=1);

namespace App\Application\Service\ViewModel\Token;

use App\Application\Http\Request\DTO\AccessToken\ClientCredentialsRequest;
use App\Application\Service\ViewModel\Token\View\ClientCredentialsModel;
use App\Application\Service\ViewModel\ViewInterface;
use App\Domain\AccessToken\AccessTokenService;
use App\Domain\AccessToken\Factory\PayloadFactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Webmozart\Assert\Assert;

final class ClientCredentialsViewModel
{
    private PayloadFactoryInterface $payloadFactory;
    private AccessTokenService $tokenEncrypter;
    private TokenStorageInterface $tokenStorage;

    public function __construct(
        PayloadFactoryInterface $payloadFactory,
        AccessTokenService $tokenEncrypter,
        TokenStorageInterface $tokenStorage
    ) {
        $this->payloadFactory = $payloadFactory;
        $this->tokenEncrypter = $tokenEncrypter;
        $this->tokenStorage = $tokenStorage;
    }

    public function createView(ClientCredentialsRequest $request): ViewInterface
    {
        /** @var TokenInterface $token */
        $token = $this->tokenStorage->getToken();

        Assert::notNull($token, 'User must be provided');

        /** @var UserInterface $user */
        $user = $token->getUser();
        $payload = $this->payloadFactory->createDirect($user->getUsername(), $request->getScopes());

        return new ClientCredentialsModel($this->tokenEncrypter->encode($payload), $payload->expires);
    }
}
