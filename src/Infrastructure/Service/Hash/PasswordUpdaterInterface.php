<?php declare(strict_types=1);

namespace App\Infrastructure\Service\Hash;

use App\Entity\User;

interface PasswordUpdaterInterface
{
    public function hashPassword(User $user): void;
}
