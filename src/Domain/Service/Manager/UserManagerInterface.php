<?php declare(strict_types=1);

namespace App\Domain\Service\Manager;

use App\Domain\Entity\User;

interface UserManagerInterface
{
    public function createUser(RegisterUserDTO $registerUser): ?User;
}
