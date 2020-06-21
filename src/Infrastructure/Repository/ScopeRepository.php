<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\Repository\ScopeRepositoryInterface;
use App\Domain\Entity\Scope;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Scope>
 */
final class ScopeRepository extends PersistenceRepository implements ScopeRepositoryInterface
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
