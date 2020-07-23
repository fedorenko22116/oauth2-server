<?php

declare(strict_types=1);

namespace App\Domain\Scope\Contract;

use App\Domain\Scope\Entity\Scope;
use App\Domain\Shared\Contract\PersistenceRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface ScopeRepositoryInterface extends PersistenceRepositoryInterface
{
    /**
     * @return ArrayCollection<Scope>
     */
    public function findDefaults(): ArrayCollection;
}
