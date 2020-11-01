<?php

declare(strict_types=1);

namespace App\Domain\Scope\Entity;

class Scope
{
    public const INFO = 'info';

    protected ?int $id = 0;
    protected string $name;
    protected string $description;
    protected bool $defaults = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isDefaults(): bool
    {
        return $this->defaults;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setDefaults(bool $default): self
    {
        $this->defaults = $default;

        return $this;
    }
}
