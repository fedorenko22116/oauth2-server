<?php declare(strict_types=1);

namespace App\Util\Hash;

interface HashGeneratorInterface
{
    public function generate(): string;
}
