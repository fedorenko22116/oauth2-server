<?php declare(strict_types=1);

namespace App\Application\Service\Request\Extractor;

use Symfony\Component\HttpFoundation\Request;

interface RequestExtractorInterface
{
    public function has(Request $request): bool;
    public function get(Request $request): string;
}
