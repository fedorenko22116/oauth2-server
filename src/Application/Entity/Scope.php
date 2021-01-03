<?php

declare(strict_types=1);

namespace App\Application\Entity;

use App\Domain\Scope\Entity\Scope as BaseScope;
use Stringable;

class Scope extends BaseScope implements Stringable
{
    public function __toString(): string
    {
        return $this->name;
    }
}
