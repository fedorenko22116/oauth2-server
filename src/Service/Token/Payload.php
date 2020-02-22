<?php declare(strict_types=1);

namespace App\Service\Token;

class Payload
{
    public int $id;
    public string $username;
    public int $ttl;

    /** @var array<string> */
    public array $scopes;
}
