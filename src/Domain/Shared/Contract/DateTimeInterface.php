<?php

declare(strict_types=1);

namespace App\Domain\Shared\Contract;

use DateTime;

interface DateTimeInterface
{
    public function getDate(): DateTime;
}
