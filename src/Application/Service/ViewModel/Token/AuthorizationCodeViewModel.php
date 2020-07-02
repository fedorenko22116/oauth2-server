<?php declare(strict_types=1);

namespace App\Application\Service\ViewModel\Token;

use App\Application\Http\Request\DTO\AccessToken\AuthorizationCodeRequest;
use App\Application\Service\ViewModel\Token\View\TokenModel;
use App\Application\Service\ViewModel\ViewInterface;
use App\Application\Service\ViewModel\ViewModelInterface;
use App\Domain\Service\Manager\RefreshTokenManagerInterface;
use App\Domain\Service\Token\Factory\PayloadFactoryInterface;
use App\Domain\Service\Token\TokenEncrypterInterface;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Webmozart\Assert\Assert;

class AuthorizationCodeViewModel implements ViewModelInterface
{
    private PayloadFactoryInterface $payloadFactory;
    private TokenEncrypterInterface $tokenEncrypter;
    private RefreshTokenManagerInterface $refreshTokenManager;

    public function __construct(
        PayloadFactoryInterface $payloadFactory,
        TokenEncrypterInterface $tokenEncrypter,
        RefreshTokenManagerInterface $refreshTokenManager
    ) {
        $this->payloadFactory = $payloadFactory;
        $this->tokenEncrypter = $tokenEncrypter;
        $this->refreshTokenManager = $refreshTokenManager;
    }

    /**
     * @param AuthorizationCodeRequest|AbstractRequest $request
     *
     * @return ViewInterface
     */
    public function createView(AbstractRequest $request): ViewInterface
    {
        Assert::subclassOf($request, AuthorizationCodeRequest::class);

        $payload = $this->payloadFactory->create($request->token);

        return new TokenModel(
            $this->tokenEncrypter->encode($payload),
            $payload->expires,
            $this->refreshTokenManager->createToken($request->token->getUser())->getToken(),
        );
    }
}
