<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Entity\Scope;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

class ScopeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scope::class);
    }

    /**
     * @return ArrayCollection<Scope>
     */
    public function findDefaults(): ArrayCollection
    {
        return new ArrayCollection($this->findBy(['default' => true]));
    }
}
