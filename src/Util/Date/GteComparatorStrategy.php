<?php declare(strict_types=1);

namespace App\Util\Date;

class GteComparatorStrategy implements ComparatorStrategyInterface
{
    public function compare(\DateTime $dateTimeA, \DateTime $dateTimeB): bool
    {
        return $dateTimeA >= $dateTimeB;
    }
}
