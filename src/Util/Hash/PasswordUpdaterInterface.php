<?php declare(strict_types=1);

namespace App\Util\Hash;

use App\Entity\User;

interface PasswordUpdaterInterface
{
    public function hashPassword(User $user): void;
}
