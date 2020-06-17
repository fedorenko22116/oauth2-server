<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\AuthToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AuthTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthToken::class);
    }

    public function findOneByToken(string $token): ?AuthToken
    {
        return $this->findOneBy(['token' => $token]);
    }
}