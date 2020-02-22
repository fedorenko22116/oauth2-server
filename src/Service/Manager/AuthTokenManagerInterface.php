<?php declare(strict_types=1);

namespace App\Service\Manager;

use App\Entity\AuthToken;
use App\Entity\Client;
use Symfony\Component\Security\Core\User\UserInterface;

interface AuthTokenManagerInterface
{
    public function createToken(UserInterface $user, Client $client, string $redirectUri): AuthToken;
}
