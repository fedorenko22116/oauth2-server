<?php declare(strict_types=1);

namespace App\Application\Service;

interface UrlGeneratorInterface
{
    /**
     * @param array<string, int|string|bool> $params
     */
    public function generateUrl(string $host, array $params): string;
}
