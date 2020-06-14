<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Entity\RefreshToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RefreshTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
    }

    public function findOneByToken(string $token): ?RefreshToken
     {
         return $this->findOneBy(['token' =>  $token]);
     }
}
