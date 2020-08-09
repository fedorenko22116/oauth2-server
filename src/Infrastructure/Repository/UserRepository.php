<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Entity\User;
use App\Domain\User\Contract\UserRepositoryInterface;
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

    public function findOneByNameOrEmail(string $username): ?User
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->where($qb->expr()->orX(
                $qb->expr()->eq('u.username', ':username'),
                $qb->expr()->eq('u.email', ':username'),
            ))
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
