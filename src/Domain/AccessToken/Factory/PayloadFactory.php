<?php declare(strict_types=1);

namespace App\Domain\AccessToken\Factory;

use App\Domain\AuthToken\Entity\AuthToken;
use App\Domain\Scope\Entity\Scope;
use App\Domain\AccessToken\Payload;
use DateTime;
use Doctrine\Common\Collections\Collection;

class PayloadFactory implements PayloadFactoryInterface
{
    public function create(AuthToken $token): Payload
    {
        return new Payload(
            $token->getUser()->getUsername(),
            (new DateTime('+10 minutes'))->getTimestamp(),
            $token->getClient()->getScopes()->map(fn(Scope $scope) => $scope->getName())->toArray(),
        );
    }

    public function createDirect(string $username, Collection $scopes): Payload
    {
        return new Payload(
            $username,
            (new DateTime('+10 minutes'))->getTimestamp(),
            $scopes->getValues(),
        );
    }
}
