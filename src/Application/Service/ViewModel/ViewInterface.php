<?php

declare(strict_types=1);

namespace App\Application\Service\ViewModel;

interface ViewInterface
{
    /**
     * @return mixed[]
     */
    public function toArray(): array;
}
