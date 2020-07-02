<?php declare(strict_types=1);

namespace App\Application\Service\ViewModel\Token;

use App\Application\Http\Request\DTO\AccessToken\ClientCredentialsRequest;
use App\Application\Service\ViewModel\Token\View\ClientCredentialsModel;
use App\Application\Service\ViewModel\ViewInterface;
use App\Application\Service\ViewModel\ViewModelInterface;
use App\Domain\Service\Token\Factory\PayloadFactoryInterface;
use App\Domain\Service\Token\TokenEncrypterInterface;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Webmozart\Assert\Assert;

class ClientCredentialsViewModel implements ViewModelInterface
{
    private PayloadFactoryInterface $payloadFactory;
    private TokenEncrypterInterface $tokenEncrypter;

    public function __construct(PayloadFactoryInterface $payloadFactory, TokenEncrypterInterface $tokenEncrypter)
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
