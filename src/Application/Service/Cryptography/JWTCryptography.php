<?php

declare(strict_types=1);

namespace App\Application\Service\Cryptography;

use Ahc\Jwt\JWT;
use App\Domain\AccessToken\Contract\CryptographyInterface;
use Webmozart\Assert\Assert;

final class JWTCryptography implements CryptographyInterface
{
    private JWT $jwt;

    public function __construct(string $privateKeyPath)
    {
        $secret = file_get_contents($privateKeyPath);

        Assert::string($secret, 'Invalid secret provided');

        $this->jwt = new JWT($secret ?: '', 'RS256');
    }

    /**
     * {@inheritDoc}
     */
    public function encode(array $payload): string
    {
        return $this->jwt->encode($payload);
    }

    /**
     * {@inheritDoc}
     */
    public function decode(string $payload): array
    {
        return $this->jwt->decode($payload);
    }
}
