<?php

declare(strict_types=1);

namespace App\Domain\User\Contract;

use App\Domain\Shared\Contract\PersistenceRepositoryInterface;
use App\Domain\User\Entity\User;

interface UserRepositoryInterface extends PersistenceRepositoryInterface
{
    public function findOneByName(string $username): ?User;
}
