<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
final class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findByCredentials(string $id, string $secret): ?Client
    {
        return $this->findOneBy([
            'id' => $id,
            'secret' => $secret,
        ]);
    }
}
