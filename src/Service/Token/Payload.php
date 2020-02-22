<?php declare(strict_types=1);

namespace App\Service\Token;

class Payload
{
    public string $username;
    public int $expires;

    /** @var array<string> */
    public array $scopes;
}
