<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\RefreshToken\Contract\RefreshTokenRepositoryInterface;
use App\Domain\RefreshToken\Entity\RefreshToken;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends PersistenceRepository<RefreshToken>
 */
final class RefreshTokenRepository extends PersistenceRepository implements RefreshTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
    }

    public function findOneByToken(string $token): ?RefreshToken
    {
        return $this->findOneBy(['token' => $token]);
    }
}
