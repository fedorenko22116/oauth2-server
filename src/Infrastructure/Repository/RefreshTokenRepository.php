<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\Repository\RefreshTokenRepositoryInterface;
use App\Domain\Entity\RefreshToken;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RefreshToken>
 */
final class RefreshTokenRepository extends PersistenceRepository implements  RefreshTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
    }

    /**
     * @param string $token
     *
     * @return RefreshToken|object|null
     */
    public function findOneByToken(string $token): ?RefreshToken
    {
        return $this->findOneBy(['token' =>  $token]);
    }

    public function save(object $object): void
    {
        // TODO: Implement save() method.
    }

    public function remove(object $object): void
    {
        // TODO: Implement remove() method.
    }
}
