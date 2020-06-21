<?php declare(strict_types=1);

namespace App\Domain\Contract;

interface CryptographyInterface
{
    public function encode(array $data): string;
    public function decode(string $payload): array;
}
