<?php declare(strict_types=1);

namespace App\Infrastructure\Service\Hash;

class DefaultHashGenerator implements HashGeneratorInterface
{
    public function generate(): string
    {
        return base64_encode(openssl_random_pseudo_bytes(256));
    }
}
