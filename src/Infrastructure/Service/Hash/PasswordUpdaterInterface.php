<?php declare(strict_types=1);

namespace App\Infrastructure\Service\Hash;

use App\Domain\Entity\User;

interface PasswordUpdaterInterface
{
    public function hashPassword(User $user): void;
}
