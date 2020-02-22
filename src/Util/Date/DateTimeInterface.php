<?php declare(strict_types=1);

namespace App\Util\Date;

use DateTime;

interface DateTimeInterface
{
    public function getDate(): DateTime;
}
