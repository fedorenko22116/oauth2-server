<?php declare(strict_types=1);

namespace App\Util\Date;

interface ComparatorStrategyInterface
{
    public function compare(\DateTime $dateTimeA, \DateTime $dateTimeB): bool;
}
