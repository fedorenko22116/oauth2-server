<?php

declare(strict_types=1);

namespace App\Application\Service\Request\Extractor;

use Symfony\Component\HttpFoundation\Request;

abstract class AuthorizationRequestExtractor implements RequestExtractorInterface
{
    final public function has(Request $request): bool
    {
        return $request->headers->has('Authorization') &&
            preg_match("/.*{$this->getType()}}\s(.*)$/", $request->headers->get('Authorization') ?: '');
    }

    final public function get(Request $request): string
    {
        return trim(preg_replace("/.*{$this->getType()}\s/", '', $request->headers->get('Authorization') ?: '') ?: '');
    }

    abstract protected function getType(): string;
}
