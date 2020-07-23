<?php

declare(strict_types=1);

namespace App\Domain\AccessToken\Contract;

interface CryptographyInterface
{
    /**
     * @param mixed[] $data
     */
    public function encode(array $data): string;

    /**
     * @return array<string, mixed>
     */
    public function decode(string $payload): array;
}
