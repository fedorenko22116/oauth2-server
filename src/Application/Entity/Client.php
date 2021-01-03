<?php

declare(strict_types=1);

namespace App\Application\Entity;

use App\Domain\Client\Entity\Client as BaseClient;
use Stringable;

class Client extends BaseClient implements Stringable
{
    public function __toString(): string
    {
        return $this->getId();
    }
}
