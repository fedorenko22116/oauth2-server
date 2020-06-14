<?php declare(strict_types=1);

namespace App\Infrastructure\Service\Hash;

interface HashGeneratorInterface
{
    public function generate(): string;
}
