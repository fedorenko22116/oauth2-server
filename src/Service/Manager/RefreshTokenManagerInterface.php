<?php declare(strict_types=1);

namespace App\Service\Manager;

use App\Entity\RefreshToken;
use Symfony\Component\Security\Core\User\UserInterface;

interface RefreshTokenManagerInterface
{
    public function createToken(UserInterface $user): RefreshToken;
}
