<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\Repository\UserRepositoryInterface;
use App\Domain\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
final class UserRepository extends PersistenceRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $username
     * @return User|null|object
     */
    public function findOneByName(string $username): ?User
    {
        return $this->findOneBy([
            'username' => $username,
        ]);
    }
}
