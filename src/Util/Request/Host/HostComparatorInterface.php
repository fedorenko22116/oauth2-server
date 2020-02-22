<?php declare(strict_types=1);

namespace App\Util\Request\Host;

interface HostComparatorInterface
{
    public function equals(string $a, string $b): bool;
}
