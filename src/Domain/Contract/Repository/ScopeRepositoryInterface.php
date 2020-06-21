<?php declare(strict_types=1);

namespace App\Domain\Contract\Repository;

use Doctrine\Common\Collections\ArrayCollection;

interface ScopeRepositoryInterface extends PersistenceRepositoryInterface
{
    public function findDefaults(): ArrayCollection;
}
