<?php declare(strict_types=1);

namespace App\Controller\API\V1;

use App\Entity\RefreshToken;
use App\Service\Manager\RefreshTokenManagerInterface;
use App\Util\Date\DateTimeInterface;
use App\Util\Date\GteComparatorStrategy;
use App\Util\DateComparatorInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * @Rest\Version("v1")
 * @Rest\Route("/api/{version}")
 */
class AuthController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/refresh-token")
     * @Rest\QueryParam("token", requirements="[\w]+")
     * @ParamConverter("refreshToken", converter="fos_rest.request_body", options={"mapping"={"token"="token"}})
     */
    public function authenticate(
        RefreshToken $refreshToken,
        DateComparatorInterface $comparator,
        DateTimeInterface $time,
        RefreshTokenManagerInterface $refreshTokenManager
    ): string {
        if ($comparator->compare(new GteComparatorStrategy(), $refreshToken->getExpires(), $time->getDate())) {
            return $refreshTokenManager->createToken($this->getUser())->getToken();
        }

        throw new AccessDeniedHttpException('Refresh token has been expired');
    }
}
