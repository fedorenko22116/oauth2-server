<?php

declare(strict_types=1);

namespace App\Domain\RefreshToken\Entity;

use App\Domain\Scope\Entity\Scope;
use App\Domain\User\Entity\User;
use DateTime;
use Doctrine\Common\Collections\Collection;

class RefreshToken
{
    protected int $id;
    protected string $token;
    protected DateTime $expires;
    protected User $user;

    /**
     * @var Collection<Scope>
     */
    protected Collection $scopes;

    /**
     * @param Collection<Scope> $scopes
     */
    public function __construct(string $token, DateTime $expires, User $user, Collection $scopes)
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
