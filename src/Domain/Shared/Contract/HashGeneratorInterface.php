<?php

declare(strict_types=1);

namespace App\Domain\Shared\Contract;

interface HashGeneratorInterface
{
    public function generate(): string;
}
