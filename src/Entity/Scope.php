<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Scope
{
    const INFO = 'info';

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /** @ORM\Column(type="string") */
    protected string $name;

    /** @ORM\Column(type="string") */
    protected string $description;

    /** @ORM\Column(type="boolean") */
    protected bool $default;

    public function getName(): string
    {
        return $this->name;
    }
}
