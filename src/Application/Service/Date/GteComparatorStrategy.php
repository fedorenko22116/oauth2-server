<?php declare(strict_types=1);

namespace App\Application\Service\Date;

use DateTime;

final class GteComparatorStrategy implements ComparatorStrategyInterface
{
    public function compare(DateTime $dateTimeA, DateTime $dateTimeB): bool
    {
        return $dateTimeA >= $dateTimeB;
    }
}
