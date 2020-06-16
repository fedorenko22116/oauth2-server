<?php declare(strict_types=1);

namespace App\Application\Controller\API;

use App\Application\Request\DTO\RefreshTokenRequest;
use App\Application\Request\DTO\AccessTokenRequest;
use App\Domain\Service\Manager\RefreshTokenManagerInterface;
use App\Domain\Service\Token\Factory\PayloadFactoryInterface;
use App\Domain\Service\Token\TokenFacadeInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("/api")
 */
class AuthenticateController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/refresh-token")
     *
     * @param RefreshTokenRequest          $request
     * @param RefreshTokenManagerInterface $refreshTokenManager
     *
     * @return string
     */
    public function refresh(RefreshTokenRequest $request, RefreshTokenManagerInterface $refreshTokenManager): string
    {
        return $refreshTokenManager->createToken($this->getUser())->getToken();
    }

    /**
     * @Rest\Post("/token")
     *
     * @param AccessTokenRequest      $request
     * @param TokenFacadeInterface    $tokenFacade
     * @param PayloadFactoryInterface $payloadFactory
     *
     * @return string
     */
    public function token(
        AccessTokenRequest $request,
        TokenFacadeInterface $tokenFacade,
        PayloadFactoryInterface $payloadFactory
    ): string {
        return $tokenFacade->encode($payloadFactory->create($request->token));
    }
}
