<?php declare(strict_types=1);

namespace App\Infrastructure\Service\Request\Host;

class HostComparator implements HostComparatorInterface
{
    public function equals(string $a, string $b): bool
    {
        return parse_url($a, PHP_URL_HOST) === parse_url($b, PHP_URL_HOST);
    }
}
