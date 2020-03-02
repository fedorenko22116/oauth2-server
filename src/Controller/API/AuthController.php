<?php declare(strict_types=1);

namespace App\Controller\API;

use App\Entity\AuthToken;
use App\Entity\RefreshToken;
use App\Entity\Scope;
use App\Request\Dto\TokenRequest;
use App\Service\Manager\RefreshTokenManagerInterface;
use App\Service\Token\Payload;
use App\Service\Token\TokenFacadeInterface;
use App\Util\Date\DateTimeInterface;
use App\Util\DateComparatorInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @Rest\Route("/api")
 */
class AuthController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/refresh-token")
     * @ParamConverter(
     *     "refreshToken",
     *      converter="app_doctrine",
     *      options={"expr"="repository.findOneByToken(token)"}
     * )
     */
    public function refresh(
        RefreshToken $refreshToken,
        DateComparatorInterface $comparator,
        DateTimeInterface $time,
        RefreshTokenManagerInterface $refreshTokenManager
    ): string {
        if ($comparator->compare($refreshToken->getExpires(), $time->getDate())) {
            return $refreshTokenManager->createToken($this->getUser())->getToken();
        }

        throw new AccessDeniedHttpException('Refresh token has been expired');
    }

    /**
     * @Rest\Post("/token")
     * @ParamConverter(
     *     "token",
     *      converter="app_doctrine",
     *      options={"expr"="repository.findOneByToken(token)"}
     * )
     */
    public function token(TokenRequest $tokenRequest, AuthToken $token, TokenFacadeInterface $tokenFacade): string
    {
        if ($tokenRequest->redirectUri !== $token->getToken()) {
            throw new BadRequestHttpException("Redirect link isn't matched");
        }

        $availableScopes = $token->getClient()->getScopes()->map(fn (Scope $scope) => $scope->getName());
        $scopes = explode(' ', $tokenRequest->grantType);

        foreach ($scopes as $scope) {
            if (!in_array($scope, $availableScopes->getValues())) {
                throw new AccessDeniedHttpException("'{$scope}' is not allowed");
            }
        }

        $payload = new Payload();
        $payload->username = $token->getUser()->getUsername();
        $payload->scopes = $scopes;
        $payload->expires = (new \DateTime('+10 minutes'))->getTimestamp();

        return $tokenFacade->encode($payload);
    }
}
