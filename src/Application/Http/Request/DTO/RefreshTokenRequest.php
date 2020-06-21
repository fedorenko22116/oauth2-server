<?php declare(strict_types=1);

namespace App\Application\Http\Request\DTO;

use App\Domain\Entity\RefreshToken;
use App\Infrastructure\Service\Date\DateTimeInterface;
use App\Infrastructure\Service\DateComparatorInterface;
use LSBProject\RequestBundle\Configuration\Entity;
use LSBProject\RequestBundle\Configuration\RequestStorage;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Psr\Container\ContainerInterface;

/**
 * @RequestStorage({"body"})
 */
class RefreshTokenRequest extends AbstractRequest
{
    /**
     * @Entity(expr="repository.findOneByToken(token)", mapping={"token": "token"})
     */
    public RefreshToken $token;

    public function validate(ContainerInterface $container): bool
    {
        return $container
            ->get(DateComparatorInterface::class)
            ->compare($this->token->getExpires(), $container->get(DateTimeInterface::class)->getDate());
    }

    public function getErrorMessage(): string
    {
        return 'Refresh token has been expired';
    }
}