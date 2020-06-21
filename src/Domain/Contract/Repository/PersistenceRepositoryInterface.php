<?php declare(strict_types=1);

namespace App\Domain\Contract\Repository;

interface PersistenceRepositoryInterface
{
    public function save(object $object): void;
    public function remove(object $object): void;
}
