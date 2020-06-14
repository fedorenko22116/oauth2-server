<?php declare(strict_types=1);

namespace App\Infrastructure\Service\Date;

use DateTime;

interface DateTimeInterface
{
    public function getDate(): DateTime;
}
