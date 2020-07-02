<?php declare(strict_types=1);

namespace App\Application\Service\ViewModel\Token;

use App\Application\Http\Request\DTO\AccessToken\ClientCredentialsRequest;
use App\Application\Service\ViewModel\Token\View\ClientCredentialsModel;
use App\Application\Service\ViewModel\ViewInterface;
use App\Application\Service\ViewModel\ViewModelInterface;
use App\Domain\AccessToken\AccessTokenService;
use App\Domain\AccessToken\Factory\PayloadFactoryInterface;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Webmozart\Assert\Assert;

class ClientCredentialsViewModel implements ViewModelInterface
{
    private PayloadFactoryInterface $payloadFactory;
    private AccessTokenService $tokenEncrypter;

    public function __construct(PayloadFactoryInterface $payloadFactory, AccessTokenService $tokenEncrypter)
    {
        $this->payloadFactory = $payloadFactory;
        $this->tokenEncrypter = $tokenEncrypter;
    }

    /**
     * @param ClientCredentialsViewModel|AbstractRequest $request
     *
     * @return ViewInterface
     */
    public function createView(AbstractRequest $request): ViewInterface
    {
        Assert::subclassOf($request, ClientCredentialsRequest::class);

        $payload = $this->payloadFactory->create($request->token);

        return new ClientCredentialsModel($this->tokenEncrypter->encode($payload), $payload->expires);
    }
}
