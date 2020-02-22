<?php declare(strict_types=1);

namespace App\Util;

use App\Util\Date\ComparatorStrategyInterface;
use DateTime;

class DateComparator implements DateComparatorInterface
{
    private ComparatorStrategyInterface $comparator;

    public function __construct(ComparatorStrategyInterface $comparator)
    {
        $this->comparator = $comparator;
    }

    public function setComparator(ComparatorStrategyInterface $strategy): self
    {
        $this->comparator = $strategy;

        return $this;
    }

    public function compare(DateTime $a, DateTime $b): bool
    {
        return $this->comparator->compare($a, $b);
    }
}
