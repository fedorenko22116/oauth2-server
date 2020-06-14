<?php declare(strict_types=1);

namespace App\Infrastructure\Service\Cryptography;

interface CryptographyInterface
{
    public function encode(array $data): string;
    public function decode(string $payload): array;
}
