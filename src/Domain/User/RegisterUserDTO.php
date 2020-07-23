<?php

declare(strict_types=1);

namespace App\Domain\User;

class RegisterUserDTO
{
    public ?string $username;
    public ?string $password;
    public ?string $email;
}
