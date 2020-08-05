<?php

declare(strict_types=1);

namespace App\Domain\User\Contract;

use App\Domain\User\Entity\User;

interface PasswordUpdaterInterface
{
    public function hashPassword(User $user): void;
}
