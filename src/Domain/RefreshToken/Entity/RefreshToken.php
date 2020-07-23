<?php

declare(strict_types=1);

namespace App\Domain\RefreshToken\Entity;

use App\Domain\Scope\Entity\Scope;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

class RefreshToken
{
    protected int $id;
    protected string $token;
    protected DateTime $expires;
    protected UserInterface $user;

    /**
     * @var Collection<Scope>
     */
    protected Collection $scopes;

    /**
     * @param Collection<Scope> $scopes
     */
    public function __construct(string $token, DateTime $expires, UserInterface $user, Collection $scopes)
    {
        $this->token = $token;
        $this->expires = $expires;
        $this->user = $user;
        $this->scopes = $scopes;
    }

    public function getExpires(): DateTime
    {
        return $this->expires;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
