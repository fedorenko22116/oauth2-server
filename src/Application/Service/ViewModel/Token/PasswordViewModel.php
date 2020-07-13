<?php declare(strict_types=1);

namespace App\Application\Service\ViewModel\Token;

use App\Application\Http\Request\DTO\AccessToken\PasswordRequest;
use App\Application\Service\ViewModel\Token\View\TokenModel;
use App\Application\Service\ViewModel\ViewInterface;
use App\Application\Service\ViewModel\ViewModelInterface;
use App\Domain\AccessToken\AccessTokenService;
use App\Domain\AccessToken\Factory\PayloadFactoryInterface;
use App\Domain\RefreshToken\RefreshTokenService;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Webmozart\Assert\Assert;

final class PasswordViewModel  implements ViewModelInterface
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
     * @param PasswordRequest|AbstractRequest $request
     *
     * @return ViewInterface
     */
    public function createView(AbstractRequest $request): ViewInterface
    {
        Assert::subclassOf($request, PasswordRequest::class);

        $token = $this->tokenStorage->getToken();

        Assert::notNull($token, 'User must be provided');

        $user = $token->getUser();
        $payload = $this->payloadFactory->createDirect($user->getUsername(), $request->getScopes());

        return new TokenModel(
            $this->tokenEncrypter->encode($payload),
            $payload->expires,
            $this->refreshTokenManager->createToken($user)->getToken(),
        );
    }
}
