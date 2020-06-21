<?php declare(strict_types=1);

namespace App\Domain\Service\Token\Factory;

use App\Domain\Entity\AuthToken;
use App\Domain\Service\Token\Payload;
use Doctrine\Common\Collections\Collection;

interface PayloadFactoryInterface
{
    public function create(AuthToken $token): Payload;

    /**
     * @param string $user
     * @param Collection<string>    $scopes
     *
     * @return Payload
     */
    public function createDirect(string $username, Collection $scopes): Payload;
}
