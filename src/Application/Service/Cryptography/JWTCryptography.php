<?php declare(strict_types=1);

namespace App\Application\Service\Cryptography;

use Ahc\Jwt\JWT;
use App\Domain\AccessToken\Contract\CryptographyInterface;

class JWTCryptography implements CryptographyInterface
{
    private JWT $jwt;

    public function __construct(string $privateKeyPath)
    {
        $this->jwt = new JWT(file_get_contents($privateKeyPath), 'RS256');
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
