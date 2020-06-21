<?php declare(strict_types=1);

namespace App\Application\Service\Date;

use App\Domain\Contract\DateTimeInterface;

class DateTimeProvider implements DateTimeInterface
{
    public function getDate(): \DateTime
    {
        return new \DateTime();
    }
}
