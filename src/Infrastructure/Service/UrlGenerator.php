<?php declare(strict_types=1);

namespace App\Infrastructure\Service;

class UrlGenerator implements UrlGeneratorInterface
{
    /**
     * {@inheritDoc}
     */
    public function generateUrl(string $host, array $params): string
    {
        return $host . http_build_query($params);
    }
}
