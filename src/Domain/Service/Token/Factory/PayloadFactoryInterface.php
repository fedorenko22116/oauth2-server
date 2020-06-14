<?php declare(strict_types=1);

namespace App\Domain\Service\Token\Factory;

use App\Domain\Entity\AuthToken;
use App\Domain\Service\Token\Payload;

interface PayloadFactoryInterface
{
    public function create(AuthToken $token): Payload;
}
