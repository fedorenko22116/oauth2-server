<?php

declare(strict_types=1);

namespace App\Application\Service\Hash;

use App\Domain\Shared\Contract\HashGeneratorInterface;

class Base64HashGenerator implements HashGeneratorInterface
{
    public function generate(): string
    {
        return base64_encode(openssl_random_pseudo_bytes(256) ?: '');
    }
}
