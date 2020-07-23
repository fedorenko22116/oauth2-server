<?php

declare(strict_types=1);

namespace App\Application\Service\ViewModel\Authorization\View;

use App\Application\Service\ViewModel\ViewInterface;

final class CodeView implements ViewInterface
{
    private string $code;
    private string $state;

    public function __construct(string $code, string $state)
    {
        $this->code = $code;
        $this->state = $state;
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'state' => $this->state,
        ];
    }
}
