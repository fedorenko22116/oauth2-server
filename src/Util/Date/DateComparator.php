<?php declare(strict_types=1);

namespace App\Util;

use App\Util\Date\ComparatorStrategyInterface;
use DateTime;

class DateComparator implements DateComparatorInterface
{
    public function compare(ComparatorStrategyInterface $comparator, DateTime $a, DateTime $b): bool
    {
        return $comparator->compare($a, $b);
    }
}
