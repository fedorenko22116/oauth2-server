<?php declare(strict_types=1);

namespace App\Util;

use App\Util\Date\ComparatorStrategyInterface;
use DateTime;

interface DateComparatorInterface
{
    public function compare(ComparatorStrategyInterface $comparator, DateTime $a, DateTime $b): bool;
}
