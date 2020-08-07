<?php

declare(strict_types=1);

namespace App\Domain\User;

class RegistrationData
{
    public ?string $username;
    public ?string $password;
    public ?string $email;

    /**
     * @var string[]|null
     */
    public ?array $roles;
}
