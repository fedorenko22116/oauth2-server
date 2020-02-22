<?php declare(strict_types=1);

namespace App\Util\Cryptography;

interface CryptographyInterface
{
    public function encode(array $data): string;
    public function decode(string $payload): array;
}
