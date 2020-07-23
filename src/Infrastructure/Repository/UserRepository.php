<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\User\Contract\UserRepositoryInterface;
use App\Domain\User\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends PersistenceRepository<User>
 */
final class UserRepository extends PersistenceRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByName(string $username): ?User
    {
        return $this->findOneBy([
            'username' => $username,
        ]);
    }
}
