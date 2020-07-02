<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\AuthToken\Contract\AuthTokenRepositoryInterface;
use App\Domain\AuthToken\Entity\AuthToken;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuthToken>
 */
final class AuthTokenRepository extends PersistenceRepository implements AuthTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthToken::class);
    }

    /**
     * @param string $token
     *
     * @return AuthToken|object|null
     */
    public function findOneByToken(string $token): ?AuthToken
    {
        return $this->findOneBy(['token' => $token]);
    }
}
