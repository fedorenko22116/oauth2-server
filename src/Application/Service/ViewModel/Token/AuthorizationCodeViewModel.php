<?php declare(strict_types=1);

namespace App\Application\Service\ViewModel\Token;

use App\Application\Http\Request\DTO\AccessToken\AuthorizationCodeRequest;
use App\Application\Service\ViewModel\Token\View\TokenModel;
use App\Application\Service\ViewModel\ViewInterface;
use App\Application\Service\ViewModel\ViewModelInterface;
use App\Domain\AccessToken\AccessTokenService;
use App\Domain\AccessToken\Factory\PayloadFactoryInterface;
use App\Domain\RefreshToken\RefreshTokenService;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Webmozart\Assert\Assert;

final class AuthorizationCodeViewModel implements ViewModelInterface
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
            $this->accessTokenService->encode($payload),
            $payload->expires,
            $this->refreshTokenManager->createToken($request->token->getUser())->getToken(),
        );
    }
}
