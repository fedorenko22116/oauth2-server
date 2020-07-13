<?php declare(strict_types=1);

namespace App\Domain\AccessToken\Contract;

interface CryptographyInterface
{
    /**
     * @param mixed[] $data
     *
     * @return string
     */
    public function encode(array $data): string;

    /**
     * @param string $payload
     *
     * @return array<string, mixed>
     */
    public function decode(string $payload): array;
}
