<?php declare(strict_types=1);

namespace App\Domain\Service\Token;

interface TokenEncrypterInterface
{
    public function encode(Payload $payload): string;
    public function decode(string $token): ?Payload;
}
