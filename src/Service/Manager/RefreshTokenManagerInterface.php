<?php declare(strict_types=1);

namespace App\Service\Manager;

use App\Entity\RefreshToken;
use App\Entity\Scope;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

interface RefreshTokenManagerInterface
{
    /**
     * @param ArrayCollection<Scope>|null $scopes
     */
    public function createToken(UserInterface $user, ?ArrayCollection $scopes = null): RefreshToken;
}
