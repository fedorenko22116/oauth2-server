<?php declare(strict_types=1);

namespace App\Application\Controller\API;

use App\Application\Request\Dto\RefreshTokenRequest;
use App\Application\Request\Dto\TokenRequest;
use App\Domain\Service\Manager\RefreshTokenManagerInterface;
use App\Domain\Service\Token\Factory\PayloadFactoryInterface;
use App\Domain\Service\Token\TokenFacadeInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("/api")
 */
class AuthController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/refresh-token")
     */
    public function refresh(RefreshTokenRequest $request, RefreshTokenManagerInterface $refreshTokenManager): string
    {
        return $refreshTokenManager->createToken($this->getUser())->getToken();
    }

    /**
     * @Rest\Post("/token")
     */
    public function token(
        TokenRequest $request,
        TokenFacadeInterface $tokenFacade,
        PayloadFactoryInterface $payloadFactory
    ): string {
        return $tokenFacade->encode($payloadFactory->create($request->token));
    }
}
