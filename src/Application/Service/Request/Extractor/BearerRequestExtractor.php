<?php declare(strict_types=1);

namespace App\Application\Service\Request\Extractor;

final class BearerRequestExtractor extends AuthorizationRequestExtractor
{
    protected function getType(): string
    {
        return 'Bearer';
    }
}
