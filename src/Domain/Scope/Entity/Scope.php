<?php declare(strict_types=1);

namespace App\Domain\Scope\Entity;

class Scope
{
    const INFO = 'info';

    /**
     * @var int
     */
    protected $id = 0;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected bool $default;

    public function getName(): string
    {
        return $this->name;
    }
}
