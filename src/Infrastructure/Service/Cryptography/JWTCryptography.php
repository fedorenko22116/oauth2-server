<?php declare(strict_types=1);

namespace App\Infrastructure\Service\Cryptography;

use Ahc\Jwt\JWT;
use Ahc\Jwt\JWTException;

class JWTCryptography implements CryptographyInterface
{
    private JWT $jwt;

    public function __construct(string $privateKeyPath)
    {
        $this->jwt = new JWT(file_get_contents($privateKeyPath), 'RS256');
    }

    public function encode(array $payload): string
    {
        $this->jwt->encode($payload);
    }

    /**
     * @throws JWTException
     */
    public function decode(string $payload): array
    {
        $this->jwt->decode($payload);
    }
}
