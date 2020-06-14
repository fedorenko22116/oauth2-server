<?php declare(strict_types=1);

namespace App\Infrastructure\Service;

interface UrlGeneratorInterface
{
    /**
     * @param array<string, int|string|bool> $params
     */
    public function generateUrl(string $host, array $params): string;
}
