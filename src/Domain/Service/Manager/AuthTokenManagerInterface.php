<?php declare(strict_types=1);

namespace App\Domain\Service\Manager;

use App\Domain\Entity\AuthToken;
use App\Domain\Entity\Client;
use Symfony\Component\Security\Core\User\UserInterface;

interface AuthTokenManagerInterface
{
    public function createToken(UserInterface $user, Client $client, string $redirectUri): AuthToken;
}
