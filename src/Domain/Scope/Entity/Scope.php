<?php

declare(strict_types=1);

namespace App\Domain\Scope\Entity;

class Scope
{
    public const INFO = 'info';

    protected ?int $id = 0;
    protected string $name;
    protected string $description;
    protected bool $default;

    public function getName(): string
    {
        return $this->name;
    }
}
