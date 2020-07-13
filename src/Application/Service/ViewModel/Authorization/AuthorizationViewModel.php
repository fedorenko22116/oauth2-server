<?php


namespace App\Application\Service\ViewModel\Authorization;


use App\Application\Http\Request\DTO\AuthorizationRequest;
use App\Application\Service\ViewModel\Authorization\View\CodeView;
use App\Application\Service\ViewModel\Authorization\View\TokenView;
use App\Application\Service\ViewModel\ViewInterface;
use App\Application\Service\ViewModel\ViewModelInterface;
use App\Domain\AccessToken\AccessTokenService;
use App\Domain\AccessToken\Factory\PayloadFactoryInterface;
use App\Domain\AuthToken\AuthTokenService;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Webmozart\Assert\Assert;

final class AuthorizationViewModel implements ViewModelInterface
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

    /**
     * @param AuthorizationRequest|AbstractRequest $request
     * @return ViewInterface
     */
    public function createView(AbstractRequest $request): ViewInterface
    {
        Assert::subclassOf($request, AuthorizationRequest::class);

        /** @var TokenInterface $token */
        $token = $this->tokenStorage->getToken();

        Assert::notNull($token);

        switch ($request) {
            case AuthorizationRequest::RESPONSE_TYPE_CODE:
                $token = $this->authTokenService
                    ->createToken($token->getUser(), $request->client, $request->redirectUri);

                return new CodeView($token->getToken(), $request->state);
            case AuthorizationRequest::RESPONSE_TYPE_TOKEN:
                $payload = $this->payloadFactory->createDirect($token->getUsername(), $request->client->getScopes());

                return new TokenView(
                    $this->accessTokenService->encode($payload),
                    $request->state,
                    $payload->expires,
                );
        }
    }
}