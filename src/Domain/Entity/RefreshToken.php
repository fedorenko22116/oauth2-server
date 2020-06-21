<?php declare(strict_types=1);

namespace App\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

class RefreshToken
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var DateTime
     */
    protected $expires;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var Collection<Scope>
     */
    protected $scopes;

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
