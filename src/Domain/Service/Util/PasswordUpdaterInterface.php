<?php declare(strict_types=1);

namespace App\Domain\Service\Util;

use App\Domain\Entity\User;

interface PasswordUpdaterInterface
{
    public function hashPassword(User $user): void;
}
