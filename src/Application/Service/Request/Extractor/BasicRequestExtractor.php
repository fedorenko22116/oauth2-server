<?php declare(strict_types=1);

namespace App\Application\Service\Request\Extractor;

final class BasicRequestExtractor extends AuthorizationRequestExtractor
{
    protected function getType(): string
    {
        return 'Basic';
    }
}
