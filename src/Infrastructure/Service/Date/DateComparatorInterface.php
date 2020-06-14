<?php declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Infrastructure\Service\Date\ComparatorStrategyInterface;
use DateTime;

interface DateComparatorInterface
{
    public function setComparator(ComparatorStrategyInterface $strategy): self;
    public function compare(DateTime $a, DateTime $b): bool;
}
